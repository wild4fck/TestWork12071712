<template>
    <div>
        <b-button v-b-modal.modal-create-student class="mb-3" variant="success">Добавить студента</b-button>

        <b-modal id="modal-create-student" ref="addModalStudent" centered hide-footer size="lg"
                 title="Добавить студента"
                 @hide="closeModal">
            <b-form @submit="submitStudent">
                <div class="d-flex w-100 student-form-wrap">
                    <div class="w-100">
                        <b-form-group
                            id="input-group-1"
                            label="Фамилия:"
                            label-for="input-1"
                        >
                            <b-form-input
                                id="input-1"
                                v-model="form.lastname"
                                placeholder="Введите фамилию"
                                required
                            ></b-form-input>
                        </b-form-group>
                        <b-form-group id="input-group-2" label="Имя:" label-for="input-2">
                            <b-form-input
                                id="input-2"
                                v-model="form.firstname"
                                placeholder="Введите имя"
                                required
                            ></b-form-input>
                        </b-form-group>
                        <b-form-group id="input-group-3" label="Отчество:" label-for="input-3">
                            <b-form-input
                                id="input-3"
                                v-model="form.secondname"
                                placeholder="Введите отчество"
                            ></b-form-input>
                        </b-form-group>
                        <b-form-group id="input-group-4" description="от 19 до 27" label="Возраст:" label-for="input-4">
                            <b-form-input
                                id="input-4"
                                v-model="form.age"
                                autocomplete="off"
                                max="27"
                                min="18"
                                placeholder="Укажите возраст"
                                required
                                type="number"
                            ></b-form-input>
                        </b-form-group>
                        <b-form-group id="input-group-6" label="Email:" label-for="input-6">
                            <b-form-input
                                id="input-6"
                                v-model="form.email"
                                placeholder="Укажите email"
                                type="email"
                            ></b-form-input>
                        </b-form-group>
                        <b-form-group id="input-group-7" label="Характеристика:" label-for="textarea-1">
                            <b-form-textarea
                                id="textarea-1"
                                v-model="form.characteristic"
                                max-rows="6"
                                rows="3"
                            ></b-form-textarea>
                        </b-form-group>
                    </div>
                    <div class="add-courses w-100 ml-3 pl-3">
                        <b-form-group id="input-group-6" label="Курсы:" label-for="input-6">
                            <div class="student-course-chooser overflow-auto pr-3">
                                <b-form-group v-for="course in coursesTeachers" :key="'input-course' + course.id"
                                              :label="course.name + ':'" :label-for="'input-course' + course.id">
                                    <b-form-select v-model="form.courses_teachers[course.id]" :options="course.teachers"
                                                   text-field="full_name"
                                                   value-field="id"></b-form-select>
                                </b-form-group>
                            </div>
                        </b-form-group>
                    </div>
                </div>

                <div class="w-100">
                    <b-button
                        class="float-right"
                        size="sm"
                        type="submit"
                        variant="success">
                        {{ editMode ? 'Сохранить' : 'Добавить' }}
                    </b-button>
                </div>

            </b-form>
        </b-modal>

        <b-table :fields="fields" :items="students" hover striped>
            <template #cell(show_details)="row">
                <b-icon class="mr-2" icon="pencil" @click="editRow(row.item)"></b-icon>
                <b-icon icon="trash" @click="deleteRow(row.item.id)"></b-icon>
            </template>
        </b-table>
    </div>
</template>

<script>

import axios from "../config/axios";

export default {
    name: 'Students',
    data() {
        return {
            fields: [
                {key: 'lastname', label: 'Фамилия', sortable: false},
                {key: 'firstname', label: 'Имя', sortable: false},
                {key: 'secondname', label: 'Отчество', sortable: false},
                {key: 'age', label: 'Возраст', sortable: false},
                {key: 'email', label: 'Email', sortable: false},
                {key: 'show_details', label: 'Управление', sortable: false},
            ],
            students: [],
            coursesTeachers: [],
            editMode: false,
            form: {
                lastname: '',
                firstname: '',
                secondname: '',
                age: '',
                email: '',
                characteristic: '',
                courses_teachers: {}
            },
        }
    },
    methods: {
        getStudents() {
            axios.get('/students').then((response) => {
                this.students = response.data;
            })
        },
        getCoursesTeacher() {
            axios.get('/courses/getWithTeachers').then((response) => {
                this.coursesTeachers = response.data;
            })
        },
        submitStudent(event) {
            event.preventDefault();
            let url = this.editMode ? '/students/edit' : '/students/add';
            axios.post(url, this.form).then((data) => {
                this.$refs.addModalStudent.hide()
                this.event()
            })
        },
        editRow(row) {
            this.editMode = true;
            this.form = {
                id: row.id,
                lastname: row.lastname,
                firstname: row.firstname,
                secondname: row.secondname,
                age: row.age,
                email: row.email,
                characteristic: row.characteristic,
                courses_teachers: this.generateCoursesFormField(row.courses_teachers)
            };
            this.$refs.addModalStudent.show()
        },
        generateCoursesFormField(courses_teachers) {
            let obj = {};
            courses_teachers.forEach(x => {
                obj[x.course_id] = x.teacher_id
            })
            return obj
        },
        deleteRow(id) {
            axios.post('students/delete', {
                id: id
            }).then((data) => {
                this.event()
            })
        },
        closeModal() {
            this.editMode = false;
            this.form = {
                lastname: '',
                firstname: '',
                secondname: '',
                age: '',
                email: '',
                characteristic: '',
                courses_teachers: {}
            }
        },
        //TODO можно вынести в mixins
        event() {
            this.$root.$emit('testWork::reload');
        }
    },
    mounted() {
        this.getStudents()
        this.getCoursesTeacher()
        //TODO можно вынести в mixins
        this.$root.$on('testWork::reload', () => {
            this.getStudents()
            this.getCoursesTeacher()
        });
    }
}
</script>


<style scoped>
.add-courses {
    border-left: 1px solid #dee2e6;
}

.student-form-wrap {
    max-height: 560px;
}

.student-course-chooser {
    max-height: 520px !important;
}
</style>
