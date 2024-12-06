new Vue({
    el: '#app',
    data: {
        data: []
    },
    methods: {
        fetchData() {
            axios
                .get('http://localhost/prueba/src/public/index.php')
                .then(response => {
                    this.data = response.data;
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                });

        }
    }
});
