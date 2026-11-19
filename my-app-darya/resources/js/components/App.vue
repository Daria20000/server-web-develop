<template>
    <div class="notification-container">
        <div v-if="article !== null" class="notification-alert" role="alert">
            <div class="notification-content">
                <strong>Новая статья!</strong>

                <p>
                    Добавлена статья:
                    <a :href="`/articles/${article.id}`">
                        {{ article.title }}
                    </a>
                </p>
            </div>

            <button
                type="button"
                class="notification-close"
                @click="article = null"
            >
                ×
            </button>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            article: null,
        };
    },

    created() {
        window.Echo.channel("test").listen(".NewArticleEvent", (event) => {
            console.log("Получено уведомление:", event);

            this.article = event.article;
        });
    },
};
</script>

<style scoped>
.notification-container {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 9999;
}

.notification-alert {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 20px;
    width: 350px;
    padding: 16px;
    background: #dbeafe;
    border: 1px solid #93c5fd;
    border-radius: 8px;
    color: #1e3a8a;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.notification-content p {
    margin: 8px 0 0;
}

.notification-alert a {
    color: #1d4ed8;
    font-weight: 600;
    text-decoration: underline;
}

.notification-close {
    border: none;
    background: transparent;
    font-size: 22px;
    cursor: pointer;
    color: #1e3a8a;
}
</style>
