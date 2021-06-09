<template>
    <div class="container-fluid">
        <div class="row mt-2">
            <div class="col-1">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Active</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Link</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Link</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                    </li>
                </ul>
            </div>
            <div class="col-3">
                
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'

    export default {
        data () {
            return {
                categories: null
            }
        },

        created: function() {
            let self = this

            axios.get('/api/categories')
                .then(function (response) {
                    self.categories = response.data.categories
                    console.log(self.categories)
                })
        }
    }
</script>

<style scoped>

</style>
