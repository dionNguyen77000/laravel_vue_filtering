<template>
   <div class="row">
        <div class="col-sm-3">
            <filters endpoint="/api/courses/filters"></filters>
        </div>
        <div class="col-sm-9">
            <div class="panel panel-default">
                <div class="panel-body">
                    <template v-if="courses.length">
                        <course v-for="course in courses" :key="course.id" :course="course"></course>
                    </template>
                    <template v-else>
                        No results found
                    </template>
                    
                    <pagination
                        v-if="meta"
                        :meta="meta" v-on:pagination:switched="getCourses"
                    ></pagination>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Course from './partials/Course.vue'
import Filters from '../filters/Filters.vue'
import Pagination from '../pagination/Pagination.vue'

export default {
    components: {
        Course,
        Pagination,
        Filters
    },
    data() {
        return {
            courses: [],
            meta: null
        }
    },
    methods: {
        getCourses(page=this.$route.query.page){
            axios.get('/api/courses',{
                params: {
                    page
                }
            }).then((response) => {
            this.courses = response.data.data
            this.meta = response.data.meta
        })
        }
    },
    mounted() {
       this.getCourses()
    }
    
}
</script>