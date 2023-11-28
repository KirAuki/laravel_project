<template>
    <div v-show="this.article != null" class="alert alert-primary" role="alert">
        Добавлен новый комментарий к статье <strong><a :href="`/articles/${this.article.id}/`">{{this.article.title}}</a></strong>
    </div>
    </template>
    <script>
        export default {
        data() { return { article: null, } },
            created() {
                window.Echo.channel('test').listen('EventNewComment', (data) => {
                    console.log(data);
                    this.article=data.article;

                })
            }
        }
    </script>