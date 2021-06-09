<template>
    <div class="container">
        <div class="row mt-lg-5">
            <div class="col-1">
                <ul class="nav flex-column">
                    <li class="nav-item" v-for="(category, i) in categories" :value="category" v-on:click="handleCategoryClick(category)">
                        <a class="nav-link" href="#">{{ category }}</a>
                    </li>
                </ul>
            </div>
            <div class="col-7">
                <h2>Random joke from <i style="color:red">{{ selectedCategory }}</i> category</h2>
                <div class="spinner-border" role="status" v-show="!currentCategoryRandomJoke"></div>
                <p class="lead">{{ currentCategoryRandomJoke }}</p>
            </div>
            <div class="col-4">
                <input class="form-control left-panel" placeholder="Type to search jokes..." v-model="searchQuery" v-on:keyup="handleSearch()">
                <div class="spinner-border mt-3 align-items-center" role="status" v-show="showSearchSpinner"></div>
                <div class="mt-3">
                    <ul class="list-group">
                        <li class="list-group-item" v-for="(joke, i) in searchResult">{{ joke.value }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'

    export default {
        data () {
            return {
                categories: null,
                selectedCategory: '',
                currentCategoryRandomJoke: '',
                searchQuery: '',
                searchResult: null,
                totalSearchResult: 0,
                showSearchSpinner: false
            }
        },

        created: function() {
            let self = this

            axios.get('/api/categories')
                .then(function (response) {
                    self.categories = response.data.categories
                    self.selectedCategory = self.categories[0];
                })

            this.handleCategoryClick(self.selectedCategory)
        },

        methods: {
            handleCategoryClick: function (category) {
                let self = this;
                this.currentCategoryRandomJoke = ''

                this.selectedCategory = category
                axios.get('/api/random-joke?category=' + category)
                    .then(function (response) {
                        self.currentCategoryRandomJoke = response.data.random_joke.value
                    })

                this.handleSearch()
            },

            handleSearch: function () {
                let self = this;
                this.showSearchSpinner = true
                if (this.searchQuery.length < 3) {
                    this.searchResult = null
                    this.showSearchSpinner = false
                    return
                }

                axios.get('/api/search-joke?query=' + this.searchQuery)
                    .then(function (response) {
                        self.searchResult = response.data.jokes.result
                        self.showSearchSpinner = false
                    }).catch(function (error) {
                        console.log(error)
                    })
            }
        }
    }
</script>

<style scoped>

</style>
