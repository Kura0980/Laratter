<template>
<div class="media post">
  <img class="align-self-start mr-3 rounded-circle user-icon" src="/img/icon/default_icon.png" alt="Generic placeholder image">
  <div class="media-body">
    <h5 class="mt-0">{{ name }}</h5>
    <p>{{ post.sentence }}</p>
  </div>
</div>
</template>

<script>
export default {
    props: {
        post: Object,
        name: String,
    }
}
</script>

<style scoped>
.post {
    border-bottom: solid 1px;
    padding-top: 10px;
    padding-bottom: 10px;
}

@media (min-width: 600px) {
    .user-icon{
        margin: 5px;
        width: 50px;
        background-color: #d0cccc;
    }
}

@media (max-width: 599px) {
    .user-icon{
        margin: 5px;
        width: 30px;
        background-color: #d0cccc;
    }
}
</style>