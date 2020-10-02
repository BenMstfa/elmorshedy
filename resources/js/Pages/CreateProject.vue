<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create New Project
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg py-12" style="padding: 25px">
                    <jet-form-section @submitted="createProject">
                        <template #form>

                            <!-- Name -->
                            <div class="col-span-12 sm:col-span-4">
                                <jet-label for="name_ar" value="Name Ar"/>
                                <input class="form-input rounded-md shadow-sm mt-1 block w-full"
                                       ref="input" v-model="name_ar">

                                <jet-input-error :message="nameArErrors.join(', ')" class="mt-2"/>
                            </div>

                            <div class="col-span-12 sm:col-span-4">
                                <jet-label for="name_en" value="Name En"/>
                                <input class="form-input rounded-md shadow-sm mt-1 block w-full"
                                       ref="input" v-model="name_en">
                                <jet-input-error :message="nameEnErrors.join(', ')" class="mt-2"/>
                            </div>

                            <!-- Email -->
                            <div class="col-span-6 sm:col-span-4">
                                <jet-label for="description_ar" value="Description Ar"/>
                                <textarea class="form-input rounded-md shadow-sm mt-1 block w-full"
                                          v-model="description_ar"
                                          rows="3"></textarea>

                                <jet-input-error :message="descriptionArErrors.join(', ')" class="mt-2"/>
                            </div>

                            <div class="col-span-6 sm:col-span-4">
                                <jet-label for="description_en" value="Description En"/>
                                <textarea class="form-input rounded-md shadow-sm mt-1 block w-full"
                                          v-model="description_en"
                                          rows="3"></textarea>
                                <jet-input-error :message="descriptionEnErrors.join(', ')" class="mt-2"/>
                            </div>

                            <div class="col-span-6 sm:col-span-4">
                                <jet-label value="Select Project photos"/>

                                <el-upload
                                    action="#"
                                    ref="projectPhotosRef"
                                    list-type="picture-card"
                                    :auto-upload="false"
                                    :file-list="photosList"
                                    accept=".jp2, .png, .jpg, .jpeg, .tif, .tiff, .bmp, .gif|images"
                                    :multiple="true"
                                    name="images[]"
                                    :http-request="handlePhotoUpload"
                                >
                                    <i slot="default" class="el-icon-plus"></i>
                                    <!--<div slot="file" slot-scope="{file}">
                                        <img class="el-upload-list__item-thumbnail" :src="file.url" alt=""/>
                                        <span class="el-upload-list__item-actions">
                                                <span v-if="!disabled" class="el-upload-list__item-delete"
                                                      @click="handleCertificatesRemove(file)">
                                                    <i class="el-icon-delete"></i>
                                                </span>
                                            </span>
                                    </div>-->
                                </el-upload>
                            </div>
                        </template>

                        <template #actions>
                            <jet-button :class="{ 'opacity-25': submitting }" :disabled="submitting"
                                        @click="createProject">
                                Save
                            </jet-button>
                        </template>
                    </jet-form-section>

                </div>
            </div>
        </div>

    </app-layout>
</template>

<script>
    import AppLayout from "../Layouts/AppLayout";
    import JetFormSection from "../Jetstream/FormSection";
    import JetButton from "../Jetstream/Button";
    import JetLabel from "../Jetstream/Label";
    import JetInput from "../Jetstream/Input";
    import JetInputError from "../Jetstream/InputError";
    import JetActionMessage from "../Jetstream/ActionMessage";
    import JetTextArea from "../Jetstream/TextArea";
    import JetSecondaryButton from "../Jetstream/SecondaryButton";

    import {required} from 'vuelidate/lib/validators'
    import FormData from 'form-data';

    export default {
        name: "CreateProject",
        components: {
            AppLayout,
            JetFormSection,
            JetButton,
            JetLabel,
            JetInput,
            JetInputError,
            JetActionMessage,
            JetTextArea,
            JetSecondaryButton,
            'el-upload': () => import('element-ui/lib/upload')
        },
        validations: {
            name_ar: {required},
            name_en: {required},
            description_ar: {required},
            description_en: {required}
        },
        data: () => ({
            name_ar: '',
            name_en: '',
            description_ar: '',
            description_en: '',
            submitting: false,
            photosList: [],
            photosToUpload: []
        }),
        computed: {
            nameArErrors() {
                const errors = [];
                if (!this.$v.name_ar.$dirty) return errors;
                !this.$v.name_ar.required && errors.push('Name Ar is required!');
                return errors
            },
            nameEnErrors() {
                const errors = [];
                if (!this.$v.name_en.$dirty) return errors;
                !this.$v.name_en.required && errors.push('Name En is required!');
                return errors
            },
            descriptionArErrors() {
                const errors = [];
                if (!this.$v.description_ar.$dirty) return errors;
                !this.$v.description_ar.required && errors.push('Description Ar is required!');
                return errors
            },
            descriptionEnErrors() {
                const errors = [];
                if (!this.$v.description_en.$dirty) return errors;
                !this.$v.description_en.required && errors.push('Description En is required!');
                return errors
            },
        },
        methods: {
            handlePhotoUpload(file) {
                console.log(file)
                this.photosToUpload.push(file.file)
            },
            uploadPhotos() {
                this.$refs.photos.click();
            },
            handleCertificatesRemove(file) {
                this.$refs.projectPhotosRef.uploadFiles.map((image, index) => {
                    if (image.uid === file.uid) {
                        this.$refs.projectPhotosRef.uploadFiles.splice(index, 1)
                    }
                });
            },
            createProject() {
                this.$refs.projectPhotosRef.submit();

                this.$v.$touch();

                if (this.$v.$invalid) {
                    return false;
                }

                if (this.photosToUpload.length === 0) {
                    alert('choose at least one photo')

                    return false;
                }

                let payload = new FormData();
                payload.append('name_ar', this.name_ar);
                payload.append('name_en', this.name_en);
                payload.append('description_ar', this.description_ar);
                payload.append('description_en', this.description_en);

                payload.append('images_length', this.$refs.projectPhotosRef.uploadFiles.length)

                console.log(this.$refs.projectPhotosRef.uploadFiles);

                this.$refs.projectPhotosRef.uploadFiles.map((image, index) => {
                    payload.append(`image_${index}`, image.raw)
                })

                this.submitting = true

                axios.post('/project/store', payload)
                    .then(response => {
                        // this.clearForm();

                        this.$notify({
                            title: 'Project',
                            message: 'Project created successfully'
                        });
                    })
                    .catch(error => {

                    })
                    .finally(() => this.submitting = false)
            },
            clearForm() {
                this.name_ar = '';
                this.name_en = '';
                this.description_ar = '';
                this.description_en = '';

                this.$refs.projectPhotosRef.uploadFiles = []

                this.$v.$reset()
            }
        },
    }
</script>

<style scoped>
    @import "~element-ui/lib/theme-chalk/upload.css";
    @import "~element-ui/lib/theme-chalk/notification.css";
    @import "~element-ui/lib/theme-chalk/icon.css";

    .avatar-uploader .el-upload {
        border: 1px dashed #d9d9d9;
        border-radius: 6px;
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }

    .avatar-uploader .el-upload:hover {
        border-color: #409EFF;
    }

    .avatar-uploader-icon {
        font-size: 28px;
        color: #8c939d;
        width: 178px;
        height: 178px;
        line-height: 178px;
        text-align: center;
    }

    .avatar {
        width: 178px;
        height: 178px;
        display: block;
    }
</style>
