// resources/js/core/env-config.js
export const envConfig = {
    development: {
        debug: true,
        apiTimeout: 60000,
        enableDevTools: true
    },
    production: {
        debug: false,
        apiTimeout: 30000,
        enableDevTools: false
    }
};