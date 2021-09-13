<template>
    <div>
        <b-button v-b-modal.modal-create-course class="mb-3" variant="success">Добавить курс</b-button>

        <b-modal id="modal-create-course" ref="addModalCourse" centered hide-footer title="Добавить курс"
                 @hide="closeModal">
            <b-form @submit="submitCourse">
                <b-form-group
                    id="input-group-1"
                    label="Название:"
                    label-for="input-1"
                >
                    <b-form-input
                        id="input-1"
                        v-model="form.name"
                        placeholder="Введите название"
                        required
                    ></b-form-input>
                </b-form-group>
                <b-form-group id="input-group-2" label="Описание:" label-for="input-2">
                    <b-form-textarea
                        id="textarea"
                        v-model="form.description"
                        max-rows="6"
                        rows="3"
                    ></b-form-textarea>
                </b-form-group>

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

        <b-table :fields="fields" :items="courses" hover striped>
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
    name: 'Courses',
    data() {
        return {
            fields: [
                {key: 'name', label: 'Название', sortable: false},
                {key: 'description', label: 'Описание', sortable: false},
                {key: 'show_details', label: 'Управление', sortable: false},
            ],
            courses: [],
            editMode: false,
            form: {
                name: '',
                description: '',
            },
        }
    },
    methods: {
        getCourses() {
            axios.get('/courses').then((response) => {
                this.courses = this.$root.courses = response.data;
            })
        },
        submitCourse(event) {
            event.preventDefault();
            let url = this.editMode ? '/courses/edit' : '/courses/add';
            axios.post(url, this.form).then((response) => {
                this.$notify({
                    group: 'message',
                    type: 'success',
                    position: 'top left',
                    title: response.data.title,
                    text: response.data.text,
                });
                this.$refs.addModalCourse.hide()
                this.event()
            }).catch((error) => {
                let errorMess = '<ul>';
                if (error.response) {
                    let arError = error.response.data.errors;
                    for (let index in arError) {
                        errorMess += '<li>';
                        errorMess += arError[index].join('</li><li>');
                    }
                } else if (error.request) {
                    errorMess += error.request;
                } else {
                    errorMess += error;
                }
                errorMess += '</li></ul>';
                this.$notify({
                    group: 'message',
                    type: 'error',
                    position: 'top left',
                    title: 'Ошибка',
                    text: errorMess,
                });
            })
        },
        editRow(row) {
            this.editMode = true;
            this.form = {
                id: row.id,
                name: row.name,
                description: row.description,
            };
            this.$refs.addModalCourse.show()
        },
        deleteRow(id) {
            axios.post('courses/delete', {
                id: id
            }).then((response) => {
                this.$notify({
                    group: 'message',
                    type: 'success',
                    position: 'top left',
                    title: response.data.title,
                    text: response.data.text,
                });
                this.event()
            })
        },
        closeModal() {
            this.editMode = false;
            this.form = {
                name: '',
                description: '',
            }
        },
        //TODO можно вынести в mixins
        event() {
            this.$root.$emit('testWork::reload');
        }
    },
    mounted() {
        this.getCourses()
        //TODO можно вынести в mixins
        this.$root.$on('testWork::reload', () => {
            this.getCourses()
        });
    }
}
</script>
