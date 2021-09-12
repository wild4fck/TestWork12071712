<template>
    <div>
        <b-button v-b-modal.modal-create-teacher class="mb-3" variant="success">Добавить преподавателя</b-button>

        <b-modal id="modal-create-teacher" ref="addModalTeacher" centered hide-footer size="lg"
                 title="Добавить преподавателя"
                 @hide="closeModal">
            <b-form @submit="submitTeacher">
                <div class="d-flex w-100">
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
                        <b-form-group id="input-group-6" label="Email:" label-for="input-6">
                            <b-form-input
                                id="input-6"
                                v-model="form.email"
                                placeholder="Укажите email"
                                type="email"
                            ></b-form-input>
                        </b-form-group>
                    </div>
                    <div class="add-teacher w-100 ml-3 pl-3">
                        <b-form-group id="input-group-6" label="Курсы:" label-for="input-6">
                            <multiselect
                                id="input-7"
                                v-model="form.courses" :clear-on-select="false"
                                :close-on-select="false"
                                :hide-selected="true"
                                :multiple="true" :options="this.$root.courses" :preselect-first="false"
                                :preserve-search="true" :showNoResults="false"
                                label="name"
                                placeholder="Выберите курсы"
                                select-label="" track-by="id"></multiselect>
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

        <b-table :fields="fields" :items="teachers" hover striped>
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
    name: 'Teachers',
    data() {
        return {
            fields: [
                {key: 'lastname', label: 'Фамилия', sortable: false},
                {key: 'firstname', label: 'Имя', sortable: false},
                {key: 'secondname', label: 'Отчество', sortable: false},
                {key: 'email', label: 'Email', sortable: false},
                {key: 'show_details', label: 'Управление', sortable: false},
            ],
            teachers: [],
            editMode: false,
            form: {
                lastname: '',
                firstname: '',
                secondname: '',
                email: '',
            },
        }
    },
    methods: {
        getTeachers() {
            axios.get('/teachers').then((response) => {
                this.teachers = response.data;
            })
        },
        submitTeacher(event) {
            event.preventDefault();
            let url = this.editMode ? '/teachers/edit' : '/teachers/add';
            let courses = this.form.courses.map(a => a.id);
            let data = Object.assign(this.form, {
                courses: courses
            });
            axios.post(url, data).then((data) => {
                this.$refs.addModalTeacher.hide()
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
                email: row.email,
                courses: row.courses
            };
            this.$refs.addModalTeacher.show()
        },
        deleteRow(id) {
            axios.post('teachers/delete', {
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
                email: '',
            }
        },
        //TODO можно вынести в mixins
        event() {
            this.$root.$emit('testWork::reload');
        }
    },
    mounted() {
        this.getTeachers()
        //TODO можно вынести в mixins
        this.$root.$on('testWork::reload', () => {
            this.getTeachers()
        });
    }
}
</script>


<style scoped>
.add-teacher {
    border-left: 1px solid #dee2e6;
}
</style>
