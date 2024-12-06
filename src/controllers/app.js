new Vue({
    el: '#app',
    data: {
        data: []
    },
    methods: {
        fetchData() {
            axios
                .get('http://localhost/prueba/src/public/index.php', {
                    headers: {
                        // Agrega encabezados si es necesario (Authorization, Content-Type, etc.)
                    }
                })
                .then(response => {
                    this.data = response.data.map(item => ({
                        id: item.id,
                        contact_no: item.contact_no,
                        lastname: item.lastname,
                        createdtime: item.createdtime
                    }));
                })
                .catch(error => {
                    console.error('Error al obtener los datos:', error);
                });
        }
    }
});

