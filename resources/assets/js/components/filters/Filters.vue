<template>
    <div class="filters">
        <p v-if="filtersInUse">
            <a href="#" @click.prevent="clearFilters">Clear all filters</a>
        </p>
        <div class="list-group" v-for="map, key in filters" :key="key">
            <a
                href="#"
                class="list-group-item"
                :class="{ 'active': selectedFilters[key] === value }"
                v-for="filter, value in map" :key="filter"
                @click.prevent="activateFilter(key, value)"
            >
                {{ filter }}
            </a>
            <a
                href="#"
                class="list-group-item list-group-item-info"
                v-if="selectedFilters[key]"
                @click.prevent="clearFilter(key)"
            >
                &times; Clear this filter
            </a>
        </div>
    </div>
</template>

<script>
    export default {
        props: [
            'endpoint'
        ],
        data () {
            return {
                filters: {},
                selectedFilters: _.omit(this.$route.query, ['page'])
            }
        },
        mounted () {
            axios.get(this.endpoint).then((response) => {
                this.filters = response.data.data
            })
        },
        computed: {
            filtersInUse () {
                return !_.isEmpty(this.selectedFilters)
            }
        },
        methods: {
            activateFilter (key, value) {
                this.selectedFilters = Object.assign({}, this.selectedFilters, { [key]: value })
                this.updateQueryString()
            },
            clearFilter (key) {
                this.selectedFilters = _.omit(this.selectedFilters, key)
                this.updateQueryString()
            },
            clearFilters () {
                this.selectedFilters = {}
                this.$router.replace({ query: {} })
            },
            updateQueryString () {
                this.$router.replace({
                    query: {
                        ...this.selectedFilters,
                        page: 1
                    }
                })
            }
        }
    }
</script>
