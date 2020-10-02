<template>
    <textarea class="form-input rounded-md shadow-sm" :value="value" @input="$emit('input', $event.target.value)" ref="textarea" rows="3"></textarea>
</template>

<script>
    export default {
        props: ['value'],

        methods: {
            focus() {
                this.$refs.textarea.focus()
            }
        }
    }
</script>

