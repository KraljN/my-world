<template>
    <section>
        <div class="blog-entries post-entry-horzontal">
            <a :href="public_path + '/posts/' + post.id" class="text-decoration-none border border-start-0">
                <div class="row d-flex">
                    <div class="col-md-5 mb-4">
                        <img class="small-post-images" :src="public_path + '/assets/img/' + post.image.src"
                             :alt="post.image.src"/>
                    </div>
                    <div class="col-md-7">
                    <span class="text">
                        <div v-if="hasAdministrationAccess" class="row d-flex justify-content-center">
                            <div class="col-2">
                                <a class="mx-auto"  :href="public_path + '/posts/' + post.id + '/edit'">
                                    <span class="text-warning mx-auto"><font-awesome-icon :icon="['fas', 'pen-to-square']"/></span>
                                </a>
                            </div>
                            <div class="col-2">
                                <a @click.prevent="$modal.show('confirm ' + post.id)" href="#">
                                    <span class="text-danger mx-auto col-3"><font-awesome-icon :icon="['fas', 'trash']" /></span>
                                </a>
                            </div>

                        </div>
                    <div class="post-meta">
                        <span class="author me-2 ">
                            <img class="rounded-circle" :src="public_path + '/assets/img/' + post.author.image.src"
                                 :alt="post.author.image.alt"/>
                            <span v-html="highlight(post.author.username, query)"></span>
                        </span>•
                        <span>{{ post.created_at | formatDate }} </span> •
                        <font-awesome-icon :icon="['fas', 'comments']"/> {{ post.comments.length }}
                      </div>
                    <h2 class="responsive-08-em" v-html="highlight(post.title, query)"></h2>
                        <span class="text-dark post-meta">
                            <span class="fw-bold">Tags:</span> <span v-html="highlight(tags, query)"></span>
                        </span>
                        <br/>
                        <span class="text-dark post-meta">
                            <span class="fw-bold">Categories:</span> <span v-html="highlight(categories, query)"></span>
                        </span>
                        <br/>
                        <span class="text-dark post-meta" v-if="hasAdministrationAccess">
                            <span class="fw-bold"><font-awesome-icon :icon="['fas', 'eye']" /> Total: </span> <span>{{post.total_visits}}</span>
                            <br/>
                            <span class="fw-bold"><font-awesome-icon :icon="['fas', 'eye']" /> This Month: </span><span>{{post.this_month_visits}}</span>
                            <br/>
                            <span class="fw-bold"><font-awesome-icon :icon="['fas', 'eye']" /> This Week: </span><span>{{post.this_week_visits}}</span>
                        </span>
                        </span>
                    </div>
                </div>
                <div class="row" v-if="highlight(post.text, query, 'partialText')">
                <span
                    class="text-dark post-meta text-center"
                    v-html="highlight(post.text, query, 'partialText')">
                </span>
                </div>
            </a>
        </div>
        <modal :scrollable="true" height="auto" width="60%" :clickToClose="true" :name="'confirm ' + post.id">
            <section class="d-flex p-3 h-100 justify-content-center align-items-center">
                <div class="text-center">
                    <font-awesome-icon class="text-danger display-3 mb-2" :icon="['fas', 'triangle-exclamation']" />
                    <h6 class="font-weight-normal responsive-09-em">Are you sure you want to remove this post?</h6>
                    <div class="mt-4 d-flex align-items-center rounded justify-content-center">
                        <button @click="removePost" :class="{ btn: true, 'btn-primary': true, 'me-2': true, 'responsive-07-em': true, 'btn-sm': window.innerWidth < 500}">Remove</button>
                        <button :class="{ btn: true, 'btn-danger': true, 'responsive-07-em': true, 'btn-sm': window.innerWidth < 500}" @click.prevent="$modal.hide('confirm ' + post.id)">Cancel</button>
                    </div>
                </div>
            </section>
        </modal>
    </section>
</template>

<script>
export default {
    name: "PostHorizontal",
    props: {
        public_path:{
            type: String
        },
        post: {
            type: Object
        },
        query:{
            required: false,
            type: String,
            default: ''
        },
        roles:{
            required: false,
            type: Array,
            default: () => []
        },
        auth_user:{
            required: false,
            type: Object
        }
    },
    computed: {
        tags() {
            let output = ''
            for (let tagIndex in this.post.tags) {
                if (tagIndex > 0) {
                    output += ' • '
                }
                output += this.post.tags[tagIndex].name
            }
            return output
        },
        categories() {
            let output = ''
            for (let categoryIndex in this.post.categories) {
                if (categoryIndex > 0) {
                    output += ' • '
                }
                output += this.post.categories[categoryIndex].name
            }
            return output
        },
        hasAdministrationAccess(){
            return (this.roles.includes('writer') && this.post.user_id == this.auth_user.id ) || this.roles.includes('admin')
        }
    },
    methods: {
        highlight(words, query, type = 'fullText') {
            const indexWhenNothingIsFound = -1;
            if (query === '') {
                if (type != 'fullText') {
                    return ""
                }
                return words
            }
            if (typeof (words) === 'number') {
                words = '' + words + ''
            }
            let index = words.toLowerCase().indexOf(query.toLowerCase())

            //We didn't find anything
            if (index == indexWhenNothingIsFound) {
                if (type != 'fullText') {
                    //We won't show whole text of post if nothing is found, we will just ignore it
                    return ""
                }
                //Otherwise we will show whole string (typically username, title, tag, category)
                return words
            }

            //We will show only sentence where string is found, not whole text
            if (type != 'fullText') {
                const sentencesBefore = words.substring(0, index).split(/[.?!]/)
                const sentencesAfter = words.substring(index + query.length).split(/[.?!]/)
                const lastSentenceBeforeString = sentencesBefore.slice(-1);
                const firstSentenceAfterString = sentencesAfter[0];

                return '... ' + lastSentenceBeforeString + "<span class='bg-yellow'>" + words.substring(index, index + query.length) + "</span>" + firstSentenceAfterString + ' ...'
            }

            return words.substring(0, index) + "<span class='bg-yellow'>" + words.substring(index, index + query.length) + "</span>" + words.substring(index + query.length)

        },
        removePost(){
            axios.delete(this.public_path + '/posts/' + this.post.id)
                .then(response => {
                    //Show message in parent component because this one will be deleted
                    this.$root.$emit('deletedPost')
                    this.$modal.hide('confirm ' + this.post.id)
                    //Destroy this component after deleting it
                    setTimeout(function(scope){
                        scope.$destroy
                        scope.$el.parentNode.removeChild(scope.$el);
                    }, 100, this)
                })
                .catch(error => {
                    console.error(error);
                });
        }

    }
}
</script>

<style scoped>

</style>
