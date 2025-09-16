<script setup>

</script>
<template>
    <div class="loader">
        <div class="round"></div>
    </div>    
</template>
<style scoped>
@keyframes spin {
    to{
        transform: rotate(0deg);
    }

    from{
        transform: rotate(360deg);
    }
    
}
.loader{
    width: 100%;
    margin: 50px 0px;
}
.round{
    margin: auto;
    width: 50px;
    height: 50px;
    border: solid #e2e2e2 7px;
    border-radius: 50%;
    border-right: solid var(--surface-card) 7px;
    animation: spin 1s linear infinite
}
</style>