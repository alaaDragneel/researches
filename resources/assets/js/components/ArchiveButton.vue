<template>
    <button type="button" :class="classes" @click="archive" v-text="value"></button>
</template>

<script>
    export default {
        props: ['postId', 'isArchive'],
        data() {
            return {
                isArchived: this.isArchive
            };
        },
        computed: {
            endpoint() {
                return `/api/posts/${this.postId}/archive`;
            },
            classes () {
                return ['btn', this.isArchived ? 'btn-warning' : 'btn-success', 'btn-sm'];
            },
            value () {
                return this.isArchived ? 'Un Archive' : 'Archive';
            },
        },
        methods: {
            archive() {
                let method = this.isArchived ? 'delete' : 'patch';

                axios[method](this.endpoint)
                    .then(({data}) => {
                        this.isArchived = ! this.isArchived;
                    });
            }
        }
    }
</script>
