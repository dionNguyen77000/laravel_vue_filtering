<template>
    <nav v-if="meta.total >= 1">
        <ul class="pagination">
            <li :class="{ 'disabled': meta.current_page === 1 }">
                <a href="#" @click.prevent="switched(meta.current_page - 1)">
                    <span>&laquo;</span>
                </a>
            </li>
            <li v-for="x in meta.last_page" :class="{ 'active': meta.current_page === x }">
                <a href="#" @click.prevent="switched(x)">{{ x }}</a>
            </li>
            <li :class="{ 'disabled': meta.current_page === meta.last_page }">
                <a href="#" @click.prevent="switched(meta.current_page + 1)">
                    <span>&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>
</template>

<script>
    export default {
        props: [
            'meta'
        ],
        methods: {
            switched (page) {
                if (this.pageIsOutOfBounds(page)) {
                    return;
                }

                this.$emit('pagination:switched', page)

                this.$router.replace({
                    query: Object.assign({}, this.$route.query, { page: page })
                })
            },
            pageIsOutOfBounds (page) {
                return page <= 0 || page > this.meta.last_page
            }
        }
    }
</script>
