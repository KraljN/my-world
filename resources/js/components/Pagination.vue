<template>
        <ul class="pagination d-flex justify-content-center" :class="customClass">
            <li class="previous-page page-item" @click.prevent="changePage(prevPage)" v-if="hasPrev">
                <a href="#" class="page-link" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>

            <li @click.prevent="changePage(page)" class="page-item" :class="{ 'active': current == page }" v-for="page in pages">
                <a href="#" class="page-link" v-text="page"></a>
            </li>

            <li class="next-page page-item" @click.prevent="changePage(nextPage)" v-if="hasNext">
                <a href="#"  class="page-link" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
</template>

<script>
export default {
    props: {
        current: {
            type: Number,
            default: 1,
            required: true
        },
        total: {
            type: Number,
            default: 0,
            required: true
        },
        perPage: {
            type: Number,
            default: 0,
            required: true
        },
        pageSidesRange: {
            type: Number,
            default: 3
        },
        customClass: {
            type: String,
            default: 'custom-pagination-class'
        }
    },

    computed: {
        pages() {
            var pages = []

            for (var i = this.rangeStart; i <= this.rangeEnd; i++) {
                pages.push(i)
            }

            return pages
        },
        rangeStart() {
            let start = this.current - this.pageSidesRange
            return (start > 0) ? start : 1
        },
        rangeEnd() {
            let end = this.current + this.pageSidesRange
            return (end < this.totalPages) ? end : this.totalPages
        },
        totalPages() {
            return Math.ceil(this.total / this.perPage)
        },
        nextPage() {
            return this.current + 1
        },
        prevPage() {
            return this.current - 1
        },
        hasPrev() {
            return this.current > 1
        },
        hasNext() {
            return this.current < this.totalPages
        }
    },

    methods: {
        changePage(page) {
            this.$emit('page-changed', page)
        }
    }
}
</script>
