<script setup>
import Button from 'primevue/button';
</script>

<template>
    
    <div class="flex items-center justify-center min-h-screen overflow-hidden" style="    width: 400px;margin: 40px auto;">
        <div class="flex flex-col items-center justify-center">
            <div style="border-radius: 56px; padding: 0.3rem; background: linear-gradient(180deg, color-mix(in srgb, var(--primary-color), transparent 60%) 10%, var(--surface-ground) 30%);text-align: center;">
                <div class="w-full bg-surface-0 dark:bg-surface-900 py-20 px-8 sm:px-20 flex flex-col items-center" style="border-radius: 53px">
                    <h4 class="text-primary font-bold text-3xl">404</h4>
                    <h1 class="text-surface-900 dark:text-surface-0 font-bold text-3xl lg:text-5xl mb-2">Página não encontrada</h1>
                    <RouterLink class="mt-5" to="/"><Button>Home Page</Button></RouterLink>
                </div>
            </div>
        </div>
    </div>
</template>
