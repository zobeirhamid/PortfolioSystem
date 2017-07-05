<template>
    <div>
        <h2>Create a new Link</h2>
        <link-form uri="/api/links" method="post"></link-form>
    </div>
</template>

<script>
    import LinkForm from '../components/LinkForm';
    export default {
        components: {'link-form': LinkForm}
    }
</script>
