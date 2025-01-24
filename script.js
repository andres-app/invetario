document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("formInventario");
    const mensaje = document.getElementById("mensaje");

    // Buscar activo
    document.getElementById("buscarInventario").addEventListener("click", function () {
        const codigo = document.getElementById("codigo_sbn_input").value.trim();

        if (codigo === "") {
            alert("Por favor, ingrese un código patrimonial.");
            return;
        }

        fetch("obtener_datos.php?codigo_barras=" + codigo)
            .then(response => response.json())
            .then(data => {
                if (data.exito) {
                    document.getElementById("codigo_sbn_hidden").value = codigo;

                    document.getElementById("bien").value = data.bien || "";
                    document.getElementById("nombre_equipo").value = data.nombre_equipo || "";
                    document.getElementById("procesador").value = data.procesador || "";
                    document.getElementById("sistema_operativo").value = data.sistema_operativo || "";
                    document.getElementById("memoria_ram").value = data.memoria_ram || "";
                    document.getElementById("capacidad_disco").value = data.capacidad_disco || "";
                    document.getElementById("area").value = data.area || "";
                    document.getElementById("usuario").value = data.usuario || "";
                    document.getElementById("nombres_completos").value = data.nombres_completos || "";
                    document.getElementById("marca").value = data.marca || "";
                    document.getElementById("modelo").value = data.modelo || "";
                    document.getElementById("serie").value = data.serie || "";
                    document.getElementById("estado").value = data.estado || "";

                    form.style.display = "block";
                    mensaje.style.display = "none";
                } else {
                    alert(data.mensaje);
                    form.reset();
                    form.style.display = "none";
                }
            })
            .catch(err => {
                console.error("Error en la consulta:", err);
                alert("Error al buscar el activo.");
            });
    });

    // Enviar formulario sin recargar la página
    form.addEventListener("submit", function (e) {
        e.preventDefault();

        const formData = new FormData(form);

        fetch("procesar_formulario.php", {
            method: "POST",
            body: formData,
        })
            .then(response => response.text())
            .then(data => {
                mensaje.innerText = data;
                mensaje.style.display = "block";
                mensaje.className = "success";
            })
            .catch(err => {
                console.error("Error al guardar los datos:", err);
                mensaje.innerText = "Error al guardar los datos.";
                mensaje.style.display = "block";
                mensaje.className = "error";
            });
    });
});
