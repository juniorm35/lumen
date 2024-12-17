let lastFetchedData = [];  // Para almacenar los datos previos y compararlos con los nuevos

document.addEventListener('DOMContentLoaded', async function () {
    const humedadData = document.getElementById("humedad-data");
    const newDataAlert = document.getElementById("new-data-alert");
    
    // Establecer el idioma de Moment.js a español
    moment.locale('es');  // Esto asegura que se use el idioma español para mostrar el tiempo

    // Función para obtener y mostrar los datos
    async function fetchData() {
        try {
            const response = await fetch("http://localhost/lumen/public/sensor-data");
            const data = await response.json();
            const fragment = document.createDocumentFragment();

            // Filtrar nuevos datos (los que no están en lastFetchedData)
            const newData = data.filter(item => !lastFetchedData.some(prevItem => prevItem.id === item.id));

            if (newData.length > 0) {
                // Mostrar alerta de nuevos datos
                newDataAlert.style.display = "block";  // Mostrar alerta
                setTimeout(() => newDataAlert.style.display = "none", 3000);  // Ocultar después de 3 segundos

                // Crear elementos para los nuevos datos
                newData.forEach(item => {
                    const humedadItem = document.createElement("div");
                    humedadItem.classList.add("humedad-item");
                
                    // Formatear tiempo (asume que hay un campo `created_at`)
                    const formattedTime = item.created_at ? moment(item.created_at).fromNow() : 'Tiempo no disponible';
                
                    humedadItem.innerHTML = `
                        <div>
                            <p><strong>Humedad:</strong> <span class="humedad-value">${item.humedad}%</span></p>
                            <p><strong>Temperatura:</strong> <span class="temp-value">${item.temperatura}°C</span></p>
                            <p class="humedad-time">${formattedTime}</p>
                        </div>
                    `;
                
                    fragment.appendChild(humedadItem);
                });
                
                // Agregar el nuevo dato al principio del contenedor
                humedadData.prepend(fragment);
            }

            // Actualizar los datos cargados previamente
            lastFetchedData = data;
        } catch (error) {
            humedadData.innerHTML = "<p>Ocurrió un error al cargar los datos. Intenta más tarde.</p>";
            console.error('Error al cargar los datos:', error);
        }
    }

    // Inicializar la carga de datos al cargar la página
    await fetchData();

    // Verificar nuevos datos cada 2 segundos
    setInterval(fetchData, 2000);
});
