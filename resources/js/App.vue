<template>
    <div class="main">
        <router-view class="main-container container"></router-view>
    </div>
</template>

<style>
    html, body{
        height: 100%;
        margin: 0px;
        overflow-y: scroll;
    }
    .main{
        min-height: 100%;
        background-color:#e8e8e8;
    }
    .main-container{
        min-height: 100%;
        background-color: white;
        padding: 0px;
    }
</style>