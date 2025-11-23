document.getElementById("ruta").addEventListener("change", calcularLlegada);
document.getElementById("fecha").addEventListener("change", calcularLlegada);
document.getElementById("hora").addEventListener("change", calcularLlegada);

function calcularLlegada() {
    let rutaid = document.getElementById("ruta").value;
    let fecha = document.getElementById("fecha").value;
    let hora = document.getElementById("hora").value;

    if (rutaid === "" || fecha === "" || hora === "") {
        return;
    }

    let fecha_salida = fecha + " " + hora;

    const params = new URLSearchParams({ idRuta: rutaid, salida: fecha_salida });
    fetch("Ajax/calcularLlegada.php?" + params.toString())
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                console.error(data.error);
                return;
            }

            document.getElementById("fecha_llegada").value = data.fecha_llegada;

            avionesDisponibles(fecha_salida, data.fecha_llegada);
            pilotosDisponibles(fecha_salida, data.fecha_llegada);
        })
        .catch(err => console.error('Error calculando llegada:', err));
}

function avionesDisponibles(fecha_salida, fecha_llegada) {
    const body = new URLSearchParams({ fecha_salida: fecha_salida, fecha_llegada: fecha_llegada });
    fetch("Ajax/avionesDisponibles.php", {
        method: "POST",
        headers: {"Content-Type": "application/x-www-form-urlencoded"},
        body: body.toString()
    })
    .then(response => response.json())
    .then(json => {
        const avionEl = document.getElementById("avion");
        let html = "";
        if (json.error) {
            html = "<option value=''>No hay aviones disponibles</option>";
        } else if (json.data && json.data.length > 0) {
            html = "<option value=''>Seleccione un avión</option>";
            json.data.forEach(a => {
                html += `<option value='${a.id}'>${a.modelo} (Capacidad: ${a.capacidad})</option>`;
            });
        } else {
            html = "<option value=''>No hay aviones disponibles</option>";
        }
        if (avionEl) avionEl.innerHTML = html;
    })
    .catch(err => console.error('Error avionesDisponibles:', err));
}

function pilotosDisponibles(fecha_salida, fecha_llegada) {
    const body = new URLSearchParams({ fecha_salida: fecha_salida, fecha_llegada: fecha_llegada });

    fetch("Ajax/pilotosDisponibles.php", {
        method: "POST",
        headers: {"Content-Type": "application/x-www-form-urlencoded"},
        body: body.toString()
    })
    .then(response => response.json())
    .then(json => {
        const pilotoEl = document.getElementById("piloto_principal");
        let html = "";
        if (json.error) {
            html = "<option value=''>No hay pilotos disponibles</option>";
        } else if (json.data && json.data.length > 0) {
            html = "<option value=''>Seleccione un piloto</option>";
            json.data.forEach(p => {
                html += `<option value='${p.id}'>${p.nombre} ${p.apellido}</option>`;
            });
        } else {
            html = "<option value=''>No hay pilotos disponibles</option>";
        }
        if (pilotoEl) {
            pilotoEl.innerHTML = html;
            pilotoEl.onchange = function() {
                const fechaSalida = document.getElementById("fecha").value + " " + document.getElementById("hora").value;
                const fechaLlegada = document.getElementById("fecha_llegada").value;
                copilotosDisponibles(fechaSalida, fechaLlegada, this.value);
            };
        }
    })
    .catch(err => console.error('Error pilotosDisponibles:', err));
}

function copilotosDisponibles(fecha_salida, fecha_llegada, pilotoPrincipal) {
    fetch("Ajax/copilotosDisponibles.php", {
        method: "POST",
        headers: {"Content-Type": "application/x-www-form-urlencoded"},
        body: new URLSearchParams({ 
            fecha_salida: fecha_salida, 
            fecha_llegada: fecha_llegada, 
            piloto_principal: pilotoPrincipal 
        }).toString()
    })
    .then(response => response.json())
    .then(json => {
        const copilotoEl = document.getElementById("copiloto");
        let html = "";
        if (json.error) {
            html = "<option value=''>No hay copilotos disponibles</option>";
        } else if (json.data && json.data.length > 0) {
            html = "<option value=''>Seleccione un copiloto</option>";
            json.data.forEach(p => {
                html += `<option value='${p.id}'>${p.nombre} ${p.apellido}</option>`;
            });
        } else {
            html = "<option value=''>No hay copilotos disponibles</option>";
        }
        if (copilotoEl) {
            copilotoEl.innerHTML = html;
        }
    })
    .catch(err => console.error('Error copilotosDisponibles:', err));
}