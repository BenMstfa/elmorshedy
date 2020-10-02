<template>
    <div class="hidden sm:flex sm:items-center sm:ml-6" style="text-align: left; display: inline-block">
        <jet-dropdown-link :href="`/project/${project.id}/update`">
            Update
        </jet-dropdown-link>

        <jet-dropdown-link as="button" @click="$emit('deleteProject')">
            <span style="color: red">Delete</span>
        </jet-dropdown-link>
    </div>
</template>

<script>
    import JetButton from "../Jetstream/Button";
    import JetDropdown from "../Jetstream/Dropdown";
    import JetDropdownLink from "../Jetstream/DropdownLink";

    export default {
        name: "ProjectActions",
        props: {
            project: {
                required: true,
                type: Object
            }
        },
        components: {
            JetButton,
            JetDropdown,
            JetDropdownLink
        }
    }
</script>

<style scoped>

</style>
