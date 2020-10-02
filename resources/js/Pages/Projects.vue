<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Projects
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg" style="padding: 25px">
                    <div style="margin-bottom: 25px">
                        <inertia-link href="/projects/create">
                            <jet-button type="button">
                                New Project
                            </jet-button>
                        </inertia-link>
                    </div>

                    <table class="table-fixed" style="width: 100%" id="projects-table">
                        <thead style="width: 100%">
                        <tr>
                            <th class="w-1/2 px-4 py-2">Project Name</th>
                            <th class="w-1/4 px-4 py-2">Created At</th>
                            <th class="w-1/4 px-4 py-2">Actions</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from './../Layouts/AppLayout'
    import JetButton from "../Jetstream/Button";
    import Vue from 'vue'

    export default {
        components: {
            AppLayout,
            JetButton
        },
        mounted() {
            let vm = this;

            this.projectsDatatable = $('#projects-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                scrollX: true,
                ajax: {
                    type: "POST",
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    },
                    url: '/projects/datatable'
                },
                columns: [
                    {
                        name: 'name',
                        data: 'name',
                        searchabel: true,
                        orderable: false,
                        className: 'text-center',
                        render: (data) => {
                            return data[this.$page.locale]
                        }
                    },
                    {
                        name: 'created_at',
                        data: 'created_at',
                        className: 'text-center',
                        searchabel: true,
                        orderable: false,
                    },
                    {
                        data: null,
                        searchabel: false,
                        orderable: false,
                        className: 'text-center',
                        createdCell(cell, cellData, rowData) {
                            let actions = Vue.extend(
                                require("../Components/ProjectActions").default
                            );
                            let instance = new actions({
                                propsData: {
                                    project: rowData
                                }
                            }).$on('deleteProject', function() {
                                vm.deleteProject(rowData)
                            });

                            instance.$mount();

                            $(cell).empty().append(instance.$el);
                        }
                    }
                ]
            })
        },
        data: () => ({
            projectsDatatable: ''
        }),
        methods: {
            deleteProject(project) {
                if (confirm("Are you sure to delete this project?")) {
                    axios.post(`/project/${project.id}/delete`).then(response => {
                        this.$notify({
                            title: 'Project',
                            message: 'Project deleted successfully'
                        })

                        this.projectsDatatable.ajax.reload()
                    })
                }
            }
        }
    }
</script>

<style>
    .text-center {
        text-align: center;
    }
</style>
