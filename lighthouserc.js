module.exports = {
  ci: {
    collect: {
      startServerCommand: 'php artisan serve',
      url: ['http://127.0.0.1:8000'],
    },
    upload: {
      target: 'temporary-public-storage',
    },
  },
};