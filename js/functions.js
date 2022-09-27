$(document).ready(function () {
  let edit = false;
  // Testing Jquery
  console.log("jquery is working!");
  listCuentas();
  listCursos();
  listRelator();
  listColaboradores();
  // Fetching Tasks

  // --------------------------------------- CURSOS ---------------------------------------
  //PAGINADOR
  $(document).on("click", "#boton_paginador", (e) => {
    const element = $(this)[0].activeElement;
    const num_boton = $(element).attr("num_pagina");
    const anterior = document.querySelector(".actual");
    if (anterior) anterior.classList.remove("actual");
    e.target.classList.add("actual");
    $.post("TASKS/coe-listCursos.php", { num_boton }, function (e) {
      const cursos = JSON.parse(e);
      $("#list_tbodyCursos").html("");
      let template = "";
      cursos.forEach((cursos) => {
        template += `
        <tr idCuenta = "${cursos.idCuenta}" nombreRamo = "${cursos.nombreRamo}" relator = "${cursos.relator}" idRamo= "${cursos.idRamo}">
        <td>${cursos.idCuenta}</td>
        <td>${cursos.idRamo}</td>
          <td>
              <a href="#" class="action_href_ramo">${cursos.nombreRamo}</a>
          </td>
        <td>${cursos.hh_academicas}</td>
        <td>${cursos.pre_requisito}</td>
        <td>
          <a href="#" class="action_href_relator">${cursos.relator}</a>
        </td> 
        <td>
          <button id="btn_delete_cursos"><i class="bi bi-trash"></i></button>
        </td>
        <td>
              <button id="btn_edit"><i class="bi bi-pencil-square"></i></button>
          </td>
        </tr>
                `;
      });
      $("#list_tbodyCursos").html(template);
    });
    e.preventDefault();
  });
  // SEARCH
  $("#search_cuenta").keyup(function () {
    if ($("#search_cuenta").val()) {
      let search = $("#search_cuenta").val();
      console.log(search);
      $.ajax({
        url: "TASKS/coe-searchCuentas.php",
        data: { search: search },
        type: "POST",
        success: function (response) {
          if (!response.error) {
            let search = JSON.parse(response);
            console.log(search);
            let thead = `
              <tr>
              <th>idCuenta</th>
              <th>Nombre del curso</th>
              <th>Relator</th>
              <th>Colaborador</th>
              <th>idColaborador</th>
              </tr>
              `;
            let template = "";
            search.forEach((search) => {
              template += `
              <tr>
                <td>${search.idCuenta}</td>
                <td>${search.nombreRamo}</td>
                <td>${search.relator}</td>
                <td>${search.nombre_completo}</td>
                <td>${search.idUsuario}</td>
                <td>
                    <button id="btn_delete"><i class="bi bi-trash"></i></button>
                </td>
                <td>
                <button id="btn_edit"><i class="bi bi-pencil-square"></i></button>
            </td>
              </tr>
                  `;
            });
            $("#list_theadCursos").html(thead);
            $("#list_tbodyCursos").html(template);
          }
        },
      });
    } else {
      listCursos();
    }
  });
  //DELETE CURSOS
  $(document).on("click", "#btn_delete_cursos", (e) => {
    if (confirm("¿Estás seguro de eliminar este registro?")) {
      const element = $(this)[0].activeElement.parentElement.parentElement;
      const idRamo = $(element).attr("idRamo");
      const relator = $(element).attr("relator");
      const nombreRamo = $(element).attr("nombreRamo");
      const idCuenta = $(element).attr("idCuenta");

      console.log(idRamo);
      console.log(nombreRamo);
      console.log(relator);
      $.post(
        "TASKS/coe-deleteCursos.php",
        { idRamo, nombreRamo, relator, idCuenta },
        (response) => {
          console.log(response);
          listCursos();
        }
      );
    }
  });
  //SELECT CURSOS
  $(document).on("click", "#btn_edit", (e) => {
    $("#form_registrarRamo").addClass("active");
    if (confirm("¿Desea actualizar este registro?")) {
      const element = $(this)[0].activeElement.parentElement.parentElement;
      const idCuenta = $(element).attr("idCuenta");
      const idRamo = $(element).attr("idRamo");
      const nombreRamo = $(element).attr("nombreRamo");
      const relator = $(element).attr("relator");
      $.post(
        "TASKS/coe-selectCursos.php",
        { idCuenta, nombreRamo, idRamo, relator },
        function (response) {
          const infoRamo = JSON.parse(response);
          console.log(infoRamo);
          $("#input_id").val(infoRamo.ID);
          $("#input_idRamo").val(infoRamo.idRamo);
          $("#input_areaRamo").val(infoRamo.area);
          $("#input_nombreCurso").val(infoRamo.nombreRamo);
          $("#input_hhAcademicas").val(infoRamo.hh_academicas);
          $("#input_preRequisito").val(infoRamo.pre_requisito);
          $("#input_relator").val(infoRamo.relator);
          edit = true;
        }
      );
    }
    $("#btn_sig").addClass("hide");
    $("#btn_registrarRamo").addClass("actives");
    $("#registrar").addClass("hide");
  });
  // AGREGAR RAMO
  $("#form_agregarRamo").submit(function (e) {
    const datosRamo = {
      ID: $("#input_id").val(),
      idCuenta: $("#input_idCuenta").val(),
      idRamo: $("#input_idRamo").val(),
      area: $("#input_areaRamo").val(),
      nombreCurso: $("#input_nombreCurso").val(),
      hh_academicas: $("#input_hhAcademicas").val(),
      pre_requisito: $("#input_preRequisito").val(),
      relator: $("#input_relator").val(),
    };
    const url =
      edit === false ? "TASKS/coe-insertarRamo.php" : "TASKS/coe-editRamo.php";
    $.post(url, datosRamo, function (response) {
      console.log(response);
    });
    e.preventDefault();
  });
  // LISTAR CURSOS
  function listCursos() {
    $.ajax({
      url: "TASKS/coe-listCursos.php",
      type: "GET",
      success: function (response) {
        const cursos = JSON.parse(response);
        let thead = `
        <tr>
        <th>idCuenta</th>
          <th>idRamo</th>
          <th>Nombre del ramo</th>
          <th>HH Académicas</th>
          <th>Pre-requisito </th>
          <th>Relator</th>
        </tr>
          `;
        let template = "";
        cursos.forEach((cursos) => {
          template += `
          <tr idCuenta = "${cursos.idCuenta}" nombreRamo = "${cursos.nombreRamo}" relator = "${cursos.relator}" idRamo= "${cursos.idRamo}">
          <td>${cursos.idCuenta}</td>
          <td>${cursos.idRamo}</td>
            <td>
                <a href="#" class="action_href_ramo">${cursos.nombreRamo}</a>
            </td>
          <td>${cursos.hh_academicas}</td>
          <td>${cursos.pre_requisito}</td>
          <td>
            <a href="#" class="action_href_relator">${cursos.relator}</a>
          </td> 
          <td>
            <button id="btn_delete_cursos"><i class="bi bi-trash"></i></button>
          </td>
          <td>
                <button id="btn_edit"><i class="bi bi-pencil-square"></i></button>
            </td>
          </tr>
                  `;
        });
        $("#list_theadCursos").html(thead);
        $("#list_tbodyCursos").html(template);
      },
    });
  }
  // INFO CURSOS
  $(document).on("click", ".action_href_ramo", (e) => {
    const element = $(this)[0].activeElement.parentElement.parentElement;
    const nombreRamo = $(element).attr("nombreRamo");
    console.log(nombreRamo);
    $(this)
      .delay(000)
      .queue(function () {
        $.post(
          "TASKS/coe-list_infoRamo.php",
          { nombreRamo },
          function (response) {
            const infoRamo = JSON.parse(response);
            console.log(infoRamo);
            let thead = `
          <tr>
            <th>Nombre del Curso</th>
            <th>Cuenta</th>
            <th>Área</th>
            <th>Colaborador</th>
            <th>Relator</th> 
          </tr>
            `;
            let template = "";
            infoRamo.forEach((infoRamo) => {
              template += `
          <tr idUsuario="${infoRamo.idUsuario}" relator = "${infoRamo.relator}">
          <td>${infoRamo.nombreRamo}</td>
          <td>${infoRamo.idCuenta}</td>
          <td>${infoRamo.area}</td>
          <td>
            <a href="#" class="action_href_user">${infoRamo.idUsuario}</a>
          </td>
          <td>
            <a href="#" class="action_href_relator">${infoRamo.relator}</a>
          </td>    
          <td>
            <button id="btn_delete"><i class="bi bi-trash"></i></button>
          </td>
          <td>
                <button id="btn_edit"><i class="bi bi-pencil-square"></i></button>
            </td>
          </tr>
                  `;
            });
            $("#list_theadCursos").html(thead);
            $("#list_tbodyCursos").html(template);
            $(this).dequeue();
          }
        );
      });
  });
  // INFO USUARIO
  $(document).on("click", ".action_href_user", (e) => {
    const element = $(this)[0].activeElement.parentElement.parentElement;
    const Usuario = $(element).attr("idUsuario");
    console.log(Usuario);
    $.post("TASKS/coe-list_infoUsuarios.php", { Usuario }, function (response) {
      const infoUsuario = JSON.parse(response);
      console.log(infoUsuario);
      let thead = `
          <tr>
            <th>Colaborador</th>
            <th>idRamo</th>
            <th>idCurso</th>
            <th>Aprobacion</th>
            <th>Estado</th>
          </tr>
            `;
      let template = "";
      infoUsuario.forEach((infoUsuario) => {
        template += `
          <tr idCurso = "${infoUsuario.idCurso}">
          <td>${infoUsuario.idUsuario}</td>
          <td>${infoUsuario.idRamo}</td>
          <td><a href="#" class="action_href_idCurso">${infoUsuario.idCurso}</a></td>
          <td>${infoUsuario.aprobacion}</td>    
          <td>${infoUsuario.estado}</td>    
          <td>
            <button id="btn_delete"><i class="bi bi-trash"></i></button>
          </td>
          <td>
                <button id="btn_edit"><i class="bi bi-pencil-square"></i></button>
            </td>
          </tr>
                  `;
      });
      $("#list_theadCursos").html(thead);
      $("#list_tbodyCursos").html(template);
    });
  });
  // INFO RELATOR
  $(document).on("click", ".action_href_relator", (e) => {
    const element = $(this)[0].activeElement.parentElement.parentElement;
    const relator = $(element).attr("relator");
    console.log(relator);
    $.post("TASKS/coe-list_infoRelator.php", { relator }, function (response) {
      const infoRelator = JSON.parse(response);
      console.log(infoRelator);
      let thead = `
    <tr>
      <th>Nombre orador</th>
      <th>Area</th>
      <th>Cuenta</th>
      <th>Cursos brindados</th>
    </tr>
          `;
      let template = "";
      infoRelator.forEach((infoRelator) => {
        template += `
        <tr idCuenta = "${infoRelator.idCuenta}" nombreRamo="${infoRelator.nombreRamo}">
        <td>${infoRelator.relator}</td>
        <td>${infoRelator.area}</td>
        <td>
            <a href="#" class="action_href_cuenta">${infoRelator.idCuenta}</a>
        </td>
        <td>
            <a href="#" class="action_href_ramo">${infoRelator.nombreRamo}</a>
        </td>    
        <td>
          <button id="btn_delete"><i class="bi bi-trash"></i></button>
        </td>
        <td>
                <button id="btn_edit"><i class="bi bi-pencil-square"></i></button>
            </td>
        </tr>
                `;
      });
      $("#list_theadCursos").html(thead);
      $("#list_tbodyCursos").html(template);
    });
  });

  // --------------------------------------- RELATOR ---------------------------------------
  //PAGINADOR
  $(document).on("click", "#boton_paginador", (e) => {
    const element = $(this)[0].activeElement;
    const num_boton = $(element).attr("num_pagina");
    const anterior = document.querySelector(".actual");
    if (anterior) anterior.classList.remove("actual");
    console.log(num_boton);
    e.target.classList.add("actual");
    $.post("TASKS/coe-listOrador.php", { num_boton }, function (e) {
      const relator = JSON.parse(e);
      $("#list_tbodyCursos").html("");
      let template = "";
      relator.forEach((relator) => {
        template += `
          <tr relator = "${relator.relator}" idCuenta = "${relator.idCuenta}" idRamo = "${relator.idRamo}" nombreRamo = "${relator.nombreRamo}">
          <td>${relator.relator}</td>
          <td>${relator.idCuenta}</td>
          <td>${relator.idRamo}</td>
          <td>${relator.nombreRamo}</td>
          <td>${relator.estado}</td>
          <td>
            <button id="btn_delete_relator"><i class="bi bi-trash"></i></button>
          </td>
          <td>
              <button id="btn_edit"><i class="bi bi-pencil-square"></i></button>
          </td>
          </tr>
                  `;
      });
      $("#list_tbodyOrador").html(template);
    });
    e.preventDefault();
  });
  //SEARCH RELATOR
  $("#search_cuenta").keyup(function () {
    if ($("#search_cuenta").val()) {
      let search = $("#search_cuenta").val();
      console.log(search);
      $.ajax({
        url: "TASKS/coe-searchCuentas.php",
        data: { search: search },
        type: "POST",
        success: function (response) {
          if (!response.error) {
            let search = JSON.parse(response);
            console.log(search);
            let thead = `
              <tr>
              <th>idCuenta</th>
              <th>Nombre del curso</th>
              <th>Relator</th>
              <th>Colaborador</th>
              <th>idColaborador</th>
              <th>Estado</th>
              </tr>
              `;
            let template = "";
            search.forEach((search) => {
              template += `
              <tr>
                <td>${search.idCuenta}</td>
                <td>${search.nombreRamo}</td>
                <td>${search.relator}</td>
                <td>${search.nombre_completo}</td>
                <td>${search.idUsuario}</td>
                <td>${search.estado}</td>
                <td>
                    <button id="btn_delete"><i class="bi bi-trash"></i></button>
                </td>
                <td>
                <button id="btn_edit"><i class="bi bi-pencil-square"></i></button>
            </td>
              </tr>
                  `;
            });
            $("#list_theadOrador").html(thead);
            $("#list_tbodyOrador").html(template);
          }
        },
      });
    } else {
      listRelator();
    }
  });
  //DELETE RELATOR
  $(document).on("click", "#btn_delete_relator", (e) => {
    if (confirm("¿Estás seguro de eliminar este registro?")) {
      const element = $(this)[0].activeElement.parentElement.parentElement;
      const relator = $(element).attr("relator");
      const idCuenta = $(element).attr("idCuenta");
      const idRamo = $(element).attr("idRamo");
      const nombreRamo = $(element).attr("nombreRamo");

      $.post(
        "TASKS/coe-deleteOrador.php",
        { idRamo, nombreRamo, relator, idCuenta },
        (response) => {
          console.log(response);
          listRelator();
        }
      );
    }
  });
  // AGREGAR RELATOR
  $("#form_agregarOrador").submit(function (e) {
    const datosRamo = {
      ID: $("#input_id").val(),
      idCuenta: $("#input_idCuenta").val(),
      idRamo: $("#input_idRamo").val(),
      area: $("#input_areaRamo").val(),
      nombreCurso: $("#input_nombreCurso").val(),
      hh_academicas: $("#input_hhAcademicas").val(),
      pre_requisito: $("#input_preRequisito").val(),
      relator: $("#input_relator").val(),
    };
    const url =
      edit === false ? "TASKS/coe-insertarRamo.php" : "TASKS/coe-editRamo.php";
    $.post(url, datosRamo, function (response) {
      console.log(response);
    });
    e.preventDefault();
    $("#form_agregarOrador").trigger("reset");
  });
  //SELECT RELATOR
  $(document).on("click", "#btn_edit_relator", (e) => {
    $("#form_registrarOrador").addClass("active");
    if (confirm("¿Desea actualizar este registro?")) {
      const element = $(this)[0].activeElement.parentElement.parentElement;
      const idCuenta = $(element).attr("idCuenta");
      const idRamo = $(element).attr("idRamo");
      const nombreRamo = $(element).attr("nombreRamo");
      const relator = $(element).attr("relator");
      $.post(
        "TASKS/coe-selectCursos.php",
        { idCuenta, nombreRamo, idRamo, relator },
        function (response) {
          const infoRamo = JSON.parse(response);
          console.log(infoRamo);
          $("#input_id").val(infoRamo.ID);
          $("#input_idRamo").val(infoRamo.idRamo);
          $("#input_areaRamo").val(infoRamo.area);
          $("#input_nombreCurso").val(infoRamo.nombreRamo);
          $("#input_hhAcademicas").val(infoRamo.hh_academicas);
          $("#input_preRequisito").val(infoRamo.pre_requisito);
          $("#input_relator").val(infoRamo.relator);
          edit = true;
        }
      );
    }
  });
  // LIST RELATOR
  function listRelator() {
    $.ajax({
      url: "TASKS/coe-listOrador.php",
      type: "GET",
      success: function (response) {
        const relator = JSON.parse(response);
        let thead = `
      <tr>
        <th>Relator</th>
        <th>Cuenta</th>
        <th>idRamo</th>
        <th>Nombre del ramo </th>
        <th>Estado </th>
      </tr>
          `;
        let template = "";
        relator.forEach((relator) => {
          template += `
            <tr relator = "${relator.relator}" idCuenta = "${relator.idCuenta}" idRamo = "${relator.idRamo}" nombreRamo = "${relator.nombreRamo}">
            <td>${relator.relator}</td>
            <td>${relator.idCuenta}</td>
            <td>${relator.idRamo}</td>
            <td>${relator.nombreRamo}</td>
            <td>${relator.estado}</td>
            <td>
              <button id="btn_delete_relator"><i class="bi bi-trash"></i></button>
            </td>
            <td>
                <button id="btn_edit_relator"><i class="bi bi-pencil-square"></i></button>
            </td>
            </tr>
                    `;
        });
        $("#list_theadOrador").html(thead);
        $("#list_tbodyOrador").html(template);
      },
    });
  }
  //DELETE COLABORADORES
  $(document).on("click", "#btn_delete_colaborador", (e) => {
    if (confirm("¿Estás seguro de eliminar este registro?")) {
      const element = $(this)[0].activeElement.parentElement.parentElement;
      const idUsuario = $(element).attr("idUsuario");
      const correo = $(element).attr("correo");

      console.log(idUsuario);
      console.log(correo);
      $.post(
        "TASKS/coe-deleteColaborador.php",
        { idUsuario, correo },
        (response) => {
          console.log(response);
          listColaboradores();
        }
      );
    }
  });
  // AGREGAR COLABORADORES
  $("#form_agregarColaborador").submit(function (e) {
    const datosColaborador = {
      idCuenta: $("#input_idCuenta_Colaborador").val(),
      nombre_completo: $("#input_nombreCompleto").val(),
      idUsuario: $("#input_idUsuario").val(),
      area: $("#input_areaColaborador").val(),
      subgerencia: $("#input_subgerenciaColaborador").val(),
      correo: $("#input_correoColaborador").val(),
    };
    console.log(datosColaborador);
    const url =
      edit === false
        ? "TASKS/coe-insertarColaborador.php"
        : "TASKS/coe-editColaborador.php";
    $.post(url, datosColaborador, function (response) {
      console.log(response);
      listColaboradores();
    });
    e.preventDefault();
  });
  //SELECT COLABORADOR
  $(document).on("click", "#btn_edit_colaborador", (e) => {
    $("#form_registrarColaborador").addClass("active");
    $("#container_idUsuario").removeClass("active");
    $("#container_idUsuario").addClass("hide");
    if (confirm("¿Desea actualizar este registro?")) {
      const element = $(this)[0].activeElement.parentElement.parentElement;
      const idUsuario = $(element).attr("idUsuario");
      const correo = $(element).attr("correo");
      $.post(
        "TASKS/coe-selectColaborador.php",
        { idUsuario, correo },
        function (response) {
          const infoColaborador = JSON.parse(response);
          console.log(infoColaborador.idUsuario);
          $("#input_Usuario").val(infoColaborador.idUsuario);
          $("#input_nombreCompleto").val(infoColaborador.nombre_completo);
          $("#input_areaColaborador").val(infoColaborador.area);
          $("#input_subgerenciaColaborador").val(infoColaborador.subgerencia);
          $("#input_correoColaborador").val(infoColaborador.correo);
          edit = true;
        }
      );
    }
    $("#registrar").addClass("hide");
  });
  // PAGINADOR COLABORADORES
  $(document).on("click", "#action_href_colaboradores", (e) => {
    $("#paginador").html("");
    $.ajax({
      url: "paginador/botones_colab.php",
      type: "GET",
      success: function (response) {
        $("#paginador").html(response);
      },
    });
    $(document).on("click", "#boton_paginador_colab", (e) => {
      const element = $(this)[0].activeElement;
      const num_boton = $(element).attr("num_pagina");
      const anterior = document.querySelector(".actual");
      if (anterior) anterior.classList.remove("actual");
      console.log(num_boton);
      e.target.classList.add("actual");
      $.post("TASKS/coe-listColaboradores.php", { num_boton }, function (e) {
        const Usuario = JSON.parse(e);
        $("#list_tbodyOrador").html("");
        let template = "";
        Usuario.forEach((Usuario) => {
          template += `
          <tr idUsuario = "${Usuario.idUsuario}" correo = "${Usuario.correo}"">
          <td>${Usuario.nombre_completo}</td>
          <td><a href="#" class="action_href_user">${Usuario.idUsuario}</a></td>
          <td style="text-align: center;">${Usuario.area}</td>
          <td>${Usuario.idCuenta}</td>
          <td>${Usuario.subgerencia}</td>
          <td>${Usuario.correo}</td>
          <td>
            <button id="btn_delete_colaborador"><i class="bi bi-trash"></i></button>
          </td>
          <td>
              <button id="btn_edit_colaborador"><i class="bi bi-pencil-square"></i></button>
          </td>
          </tr>
                  `;
        });
        $("#list_tbodyOrador").html(template);
      });
      e.preventDefault();
    });
  });
  // COLABORADORES
  function listColaboradores() {
    $(document).on("click", "#action_href_colaboradores", (e) => {
      $.ajax({
        url: "TASKS/coe-listColaboradores.php",
        type: "GET",
        success: function (response) {
          const Usuario = JSON.parse(response);
          let thead = `
      <tr>
        <th>Nombre y apellido</th>
        <th>ID</th>
        <th>Área</th>
        <th>Cuenta</th> 
        <th>Subgerencia</th>
        <th>Correo </th>
      </tr>
          `;
          let template = "";
          Usuario.forEach((Usuario) => {
            template += `
            <tr idUsuario = "${Usuario.idUsuario}" correo = "${Usuario.correo}"">
            <td>${Usuario.nombre_completo}</td>
            <td><a href="#" class="action_href_user">${Usuario.idUsuario}</a></td>
            <td style="text-align: center;">${Usuario.area}</td>
            <td>${Usuario.idCuenta}</td>
            <td>${Usuario.subgerencia}</td>
            <td>${Usuario.correo}</td>
            <td>
              <button id="btn_delete_colaborador"><i class="bi bi-trash"></i></button>
            </td>
            <td>
                <button id="btn_edit_colaborador"><i class="bi bi-pencil-square"></i></button>
            </td>
            </tr>
                    `;
          });
          $("#list_theadOrador").html(thead);
          $("#list_tbodyOrador").html(template);
        },
      });
    });
  }
  // INFO USUARIO
  $(document).on("click", ".action_href_user", (e) => {
    const element = $(this)[0].activeElement.parentElement.parentElement;
    const Usuario = $(element).attr("idUsuario");
    console.log(Usuario);
    $.post("TASKS/coe-list_infoUsuarios.php", { Usuario }, function (response) {
      const infoUsuario = JSON.parse(response);
      console.log(infoUsuario);
      let thead = `
        <tr>
          <th>Colaborador</th>
          <th>idRamo</th>
          <th>idCurso</th>
          <th>Aprobacion</th>
          <th>Estado</th>
        </tr>
          `;
      let template = "";
      infoUsuario.forEach((infoUsuario) => {
        template += `
        <tr idCurso = "${infoUsuario.idCurso}">
        <td>${infoUsuario.idUsuario}</td>
        <td>${infoUsuario.idRamo}</td>
        <td><a href="#" class="action_href_idCurso">${infoUsuario.idCurso}</a></td>
        <td>${infoUsuario.aprobacion}</td>    
        <td>${infoUsuario.estado}</td>    
        <td>
          <button id="btn_delete"><i class="bi bi-trash"></i></button>
        </td>
        <td>
              <button id="btn_edit"><i class="bi bi-pencil-square"></i></button>
          </td>
        </tr>
                `;
      });
      $("#list_theadOrador").html(thead);
      $("#list_tbodyOrador").html(template);
    });
  });
  // INFO IDCURSO
  $(document).on("click", ".action_href_idCurso", (e) => {
    const element = $(this)[0].activeElement.parentElement.parentElement;
    const idCurso = $(element).attr("idCurso");
    console.log(idCurso);
    $.post("TASKS/coe-list_infoidCurso.php", { idCurso }, function (response) {
      const infoidCurso = JSON.parse(response);
      console.log(infoidCurso);
      let thead = `
          <tr>
            <th>ID del curso</th>
            <th>Hora Inicio</th>
            <th>Hora Fin</th>
            <th>ID del colaborador</th>
            <th>Porcentaje de aprobación</th>
            <th>Aprobación</th>
          </tr>
            `;
      let template = "";
      infoidCurso.forEach((infoidCurso) => {
        template += `
          <tr idUsuario = "${infoidCurso.idUsuario}">
          <td>${infoidCurso.idCurso}</td>
          <td>${infoidCurso.horaInicio}</td>
          <td>${infoidCurso.horaFin}</td>
          <td>
          <a href="#" class="action_href_user">${infoidCurso.idUsuario}</a>
        </td>
          <td>${infoidCurso.porcentaje_aprobacion}</td>    
          <td>${infoidCurso.estado}</td>    
          <td>
            <button id="btn_delete"><i class="bi bi-trash"></i></button>
          </td>
          <td>
                <button id="btn_edit"><i class="bi bi-pencil-square"></i></button>
            </td>
          </tr>
                  `;
      });
      $("#list_theadOrador").html(thead);
      $("#list_tbodyOrador").html(template);
    });
  });

  // --------------------------------------- CUENTA ---------------------------------------
  //PAGINADOR
  $(document).on("click", "#boton_paginador", (e) => {
    const element = $(this)[0].activeElement;
    const num_boton = $(element).attr("num_pagina");
    const anterior = document.querySelector(".actual");
    if (anterior) anterior.classList.remove("actual");
    e.target.classList.add("actual");
    $.post("TASKS/coe-listCuentas.php", { num_boton }, function (e) {
      const cuentas = JSON.parse(e);
      $("#list_tbodyCuentas").html("");
      let template = "";
      cuentas.forEach((cuentas) => {
        template += `
          <tr idCuenta="${cuentas.idCuenta}" nombreRamo="${cuentas.nombreRamo}" idCurso = '${cuentas.idCurso}'fechaInicio = "${cuentas.inicio}" fechaFin = "${cuentas.fin}">
            <td>
                <a href="#" class="action_href_cuenta">${cuentas.idCuenta}</a>
            </td>
            <td>
                <a href="#" class="action_href_ramo">${cuentas.nombreRamo}</a>
            </td>
            <td><a href="#" class="action_href_idCurso">${cuentas.idCurso}</a></td>
            <td>${cuentas.inicio}</td>
            <td>${cuentas.fin}</td>
            <td>${cuentas.estado}</td>
            <td>
                <button id="btn_delete"><i class="bi bi-trash"></i></button>
            </td>
            <td>
                <button id="btn_edit_cuenta"><i class="bi bi-pencil-square"></i></button>
            </td>
          </tr>
                  `;
      });
      $("#list_tbodyCuentas").html(template);
    });
    e.preventDefault();
  });

  //SELECT CUENTAS
  $(document).on("click", "#btn_edit_cuenta", (e) => {
    $("#form_registrarCurso").addClass("active");
    if (confirm("¿Desea actualizar este registro?")) {
      const element = $(this)[0].activeElement.parentElement.parentElement;
      const idCurso = $(element).attr("idCurso");
      $.post("TASKS/coe-selectCuentas.php", { idCurso }, function (response) {
        const infoCurso = JSON.parse(response);
        console.log(infoCurso.idCurso);
        $("#input_idCurso").val(infoCurso.idCurso);
        $("#input_fechaInicio").val(infoCurso.inicio);
        $("#input_fechaFin").val(infoCurso.fin);
        $("#input_horaInicio").val(infoCurso.hora_inicio);
        $("#input_horaFin").val(infoCurso.hora_fin);
        edit = true;
      });
    }
    $("#registrar").addClass("hide");
  });

  // AGREGAR CURSO
  $("#form_agregarCurso").submit(function (e) {
    const datosCurso = {
      idCurso: $("#input_idCurso").val(),
      idCuenta: $("#input_idCuenta_Curso").val(),
      idRamo: $("#input_idRamo_Curso").val(),
      inicio: $("#input_fechaInicio").val(),
      fin: $("#input_fechaFin").val(),
      hora_inicio: $("#input_horaInicio").val(),
      hora_fin: $("#input_horaFin").val(),
    };
    const url =
      edit === false
        ? "TASKS/coe-insertarCurso.php"
        : "TASKS/coe-editCurso.php";
    $.post(url, datosCurso, function (response) {
      console.log(response);
      listCuentas();
    });
    e.preventDefault();
  });

  // BUSCADOR
  $("#search_cuenta").keyup(function () {
    if ($("#search_cuenta").val()) {
      let search = $("#search_cuenta").val();
      console.log(search);
      $.ajax({
        url: "TASKS/coe-searchCuentas.php",
        data: { search: search },
        type: "POST",
        success: function (response) {
          if (!response.error) {
            let search = JSON.parse(response);
            console.log(search);
            let thead = `
              <tr>
              <th>idCuenta</th>
              <th>Nombre del curso</th>
              <th>Relator</th>
              <th>Colaborador</th>
              <th>idColaborador</th>
              </tr>
              `;
            let template = "";
            search.forEach((search) => {
              template += `
              <tr>
                <td>${search.idCuenta}</td>
                <td>${search.nombreRamo}</td>
                <td>${search.relator}</td>
                <td>${search.nombre_completo}</td>
                <td>${search.idUsuario}</td>
                <td>
                    <button id="btn_delete"><i class="bi bi-trash"></i></button>
                </td>
                <td>
                <button id="btn_edit_cuentas"><i class="bi bi-pencil-square"></i></button>
            </td>
              </tr>
                  `;
            });
            $("#list_theadCuentas").html(thead);
            $("#list_tbodyCuentas").html(template);
          }
        },
      });
    } else {
      listCuentas();
    }
  });

  //DELETE CUENTAS
  $(document).on("click", "#btn_delete", (e) => {
    if (confirm("¿Estás seguro de eliminar este registro?")) {
      const element = $(this)[0].activeElement.parentElement.parentElement;
      const idCuenta = $(element).attr("idCuenta");
      const nombreRamo = $(element).attr("nombreRamo");
      const idCurso = $(element).attr("idCurso");
      const fechaInicio = $(element).attr("fechaInicio");
      const fechaFin = $(element).attr("fechaFin");

      console.log(idCuenta);
      console.log(nombreRamo);
      console.log(fechaInicio);
      console.log(fechaFin);
      $.post(
        "TASKS/coe-deleteCuentas.php",
        { idCuenta, nombreRamo, idCurso, fechaInicio, fechaFin },
        (response) => {
          console.log(response);
          listCuentas();
        }
      );
    }
  });

  //LIST CUENTAS
  function listCuentas() {
    $.ajax({
      url: "TASKS/coe-listCuentas.php",
      type: "GET",
      success: function (response) {
        const cuentas = JSON.parse(response);
        let thead = `
      <tr>
      <th>idCuenta</th>
      <th>Nombre del curso</th>
      <th>ID del curso</th>
      <th>Inicio</th>
      <th>Fin</th>
      <th>Estado</th> 
      </tr>
      `;
        let template = "";
        cuentas.forEach((cuentas) => {
          template += `
          <tr idCuenta="${cuentas.idCuenta}" nombreRamo="${cuentas.nombreRamo}" idCurso = '${cuentas.idCurso}'fechaInicio = "${cuentas.inicio}" fechaFin = "${cuentas.fin}">
            <td>
                <a href="#" class="action_href_cuenta">${cuentas.idCuenta}</a>
            </td>
            <td>
                <a href="#" class="action_href_ramo">${cuentas.nombreRamo}</a>
            </td>
            <td><a href="#" class="action_href_idCurso">${cuentas.idCurso}</a></td>
            <td>${cuentas.inicio}</td>
            <td>${cuentas.fin}</td>
            <td>${cuentas.estado}</td>
            <td>
                <button id="btn_delete"><i class="bi bi-trash"></i></button>
            </td>
            <td>
                <button id="btn_edit_cuenta"><i class="bi bi-pencil-square"></i></button>
            </td>
          </tr>
                  `;
        });
        $("#list_theadCuentas").html(thead);
        $("#list_tbodyCuentas").html(template);
      },
    });
  }
  // INFO CUENTA
  $(document).on("click", ".action_href_cuenta", (e) => {
    const element = $(this)[0].activeElement.parentElement.parentElement;
    const idCuenta = $(element).attr("idCuenta");
    $(this)
      .delay(000)
      .queue(function () {
        $.post(
          "TASKS/coe-list_infoCuentas.php",
          { idCuenta },
          function (response) {
            const infoCuentas = JSON.parse(response);
            console.log(infoCuentas);
            let thead = `
            <tr>
          <th>idCuenta</th>
          <th>Colaborador</th>
          <th>idCurso</th>
          <th>% Aprobación</th> 
          </tr>
            `;
            let template = "";
            infoCuentas.forEach((infoCuentas) => {
              template += `
          <tr idUsuario="${infoCuentas.idUsuario}" idCurso = "${infoCuentas.idCurso}">
          <td>${infoCuentas.idCuenta}</td>
          <td><a href="#" class="action_href_user">${infoCuentas.idUsuario}</a></td>
          <td><a href="#" class="action_href_idCurso">${infoCuentas.idCurso}</a></td>
          <td>${infoCuentas.aprobacion}</td>    
          <td>
            <button id="btn_delete"><i class="bi bi-trash"></i></button>
          </td>
          <td>
                <button id="btn_edit"><i class="bi bi-pencil-square"></i></button>
            </td>
          </tr>
                  `;
            });
            $("#list_theadCuentas").html(thead);
            $("#list_tbodyCuentas").html(template);
            $(this).dequeue();
          }
        );
      });
  });
  // PAGINADOR INFOCUENTA
  $(document).on("click", ".action_href_cuenta", (e) => {
    $("#paginador").html("");
    $.ajax({
      url: "paginador/botones_infoCuenta.php",
      type: "GET",
      success: function (response) {
        $("#paginador").html(response);
      },
    });
    $(document).on("click", "#boton_paginador_infoCuenta", (e) => {
      const element1 = $(this)[0].activeElement.parentElement.parentElement;
      const idCuenta = $(element1).attr("idCuenta");
      // ---------------------------
      const element = $(this)[0].activeElement;
      const num_boton = $(element).attr("num_pagina");
      const anterior = document.querySelector(".actual");
      if (anterior) anterior.classList.remove("actual");
      e.target.classList.add("actual");

      $.post(
        "TASKS/coe-list_infoCuentas.php",
        { num_boton, idCuenta },
        function (response) {
          const infoCuentas = JSON.parse(response);
          $("#list_tbodyCuentas").html("");
          let template = "";
          infoCuentas.forEach((infoCuentas) => {
            template += `
          <tr idUsuario="${infoCuentas.idUsuario}" idCurso = "${infoCuentas.idCurso}">
          <td>${infoCuentas.idCuenta}</td>
          <td><a href="#" class="action_href_user">${infoCuentas.idUsuario}</a></td>
          <td><a href="#" class="action_href_idCurso">${infoCuentas.idCurso}</a></td>
          <td>${infoCuentas.aprobacion}</td>    
          <td>
            <button id="btn_delete"><i class="bi bi-trash"></i></button>
          </td>
          <td>
                <button id="btn_edit"><i class="bi bi-pencil-square"></i></button>
            </td>
          </tr>
                  `;
          });
          $("#list_tbodyCuentas").html(template);
        }
      );
    });
  });
  // INFO RAMO
  $(document).on("click", ".action_href_ramo", (e) => {
    const element = $(this)[0].activeElement.parentElement.parentElement;
    const nombreRamo = $(element).attr("nombreRamo");
    console.log(nombreRamo);
    $.post("TASKS/coe-list_infoRamo.php", { nombreRamo }, function (response) {
      const infoRamo = JSON.parse(response);
      console.log(infoRamo);
      let thead = `
          <tr>
            <th>Nombre del curso</th>
            <th>Cuenta</th>
            <th>Área</th>
            <th>ID del colaborador</th>
            <th>Relator</th>
          </tr>
            `;
      let template = "";
      infoRamo.forEach((infoRamo) => {
        template += `
          <tr idUsuario = "${infoRamo.idUsuario}" idCuenta="${infoRamo.idCuenta}" relator = "${infoRamo.relator}">
          <td>${infoRamo.nombreRamo}</td>
          <td><a href="#" class="action_href_cuenta">${infoRamo.idCuenta}</a></td>
          <td>${infoRamo.area}</td>
          <td><a href="#" class="action_href_user">${infoRamo.idUsuario}</a></td>
          <td><a href="#" class="action_href_relator">${infoRamo.relator}</a></td>
          <td>
            <button id="btn_delete"><i class="bi bi-trash"></i></button>
          </td>
          <td>
                <button id="btn_edit"><i class="bi bi-pencil-square"></i></button>
            </td>
          </tr>
                  `;
      });
      $("#list_theadCuentas").html(thead);
      $("#list_tbodyCuentas").html(template);
    });
  });
  // PAGINADOR INFO RAMO
  $(document).on("click", ".action_href_ramo", (e) => {
    $("#paginador").html("");
    $.ajax({
      url: "paginador/botones_colab.php",
      type: "GET",
      success: function (response) {
        $("#paginador").html(response);
      },
    });
    $(document).on("click", "#boton_paginador_colab", (e) => {
      const element = $(this)[0].activeElement;
      const num_boton = $(element).attr("num_pagina");
      const anterior = document.querySelector(".actual");
      if (anterior) anterior.classList.remove("actual");
      console.log(num_boton);
      e.target.classList.add("actual");
      // $.post("TASKS/coe-listColaboradores.php", { num_boton }, function (e) {
      //   const Usuario = JSON.parse(e);
      //   $("#list_tbodyOrador").html("");
      //   let template = "";
      //   Usuario.forEach((Usuario) => {
      //     template += `
      //     <tr idUsuario = "${Usuario.idUsuario}" correo = "${Usuario.correo}"">
      //     <td>${Usuario.nombre_completo}</td>
      //     <td><a href="#" class="action_href_user">${Usuario.idUsuario}</a></td>
      //     <td style="text-align: center;">${Usuario.area}</td>
      //     <td>${Usuario.idCuenta}</td>
      //     <td>${Usuario.subgerencia}</td>
      //     <td>${Usuario.correo}</td>
      //     <td>
      //       <button id="btn_delete_colaborador"><i class="bi bi-trash"></i></button>
      //     </td>
      //     <td>
      //         <button id="btn_edit_colaborador"><i class="bi bi-pencil-square"></i></button>
      //     </td>
      //     </tr>
      //             `;
      //   });
      //   $("#list_tbodyOrador").html(template);
      // });
      e.preventDefault();
    });
  });

  // INFO IDCURSO
  $(document).on("click", ".action_href_idCurso", (e) => {
    const element = $(this)[0].activeElement.parentElement.parentElement;
    const idCurso = $(element).attr("idCurso");
    console.log(idCurso);
    $.post("TASKS/coe-list_infoidCurso.php", { idCurso }, function (response) {
      const infoidCurso = JSON.parse(response);
      console.log(infoidCurso);
      let thead = `
          <tr>
            <th>ID del curso</th>
            <th>Hora Inicio</th>
            <th>Hora Fin</th>
            <th>ID del colaborador</th>
            <th>Porcentaje de aprobación</th>
          </tr>
            `;
      let template = "";
      infoidCurso.forEach((infoidCurso) => {
        template += `
          <tr idUsuario = "${infoidCurso.idUsuario}">
          <td>${infoidCurso.idCurso}</td>
          <td>${infoidCurso.horaInicio}</td>
          <td>${infoidCurso.horaFin}</td>
          <td>
          <a href="#" class="action_href_user">${infoidCurso.idUsuario}</a>
        </td>
          <td>${infoidCurso.porcentaje_aprobacion}</td>    
          <td>
            <button id="btn_delete"><i class="bi bi-trash"></i></button>
          </td>
          <td>
                <button id="btn_edit"><i class="bi bi-pencil-square"></i></button>
            </td>
          </tr>
                  `;
      });
      $("#list_theadCuentas").html(thead);
      $("#list_tbodyCuentas").html(template);
    });
  });

  //PAGINADOR INFO CURSO
  $(document).on("click", ".action_href_idCurso", (e) => {
    $("#paginador").html("");
    $.ajax({
      url: "paginador/botones_infoCursos.php",
      type: "GET",
      success: function (response) {
        $("#paginador").html(response);
      },
    });
    $(document).on("click", "#boton_paginador_infoCursos", (e) => {
      const element = $(this)[0].activeElement;
      const num_boton = $(element).attr("num_pagina");
      const anterior = document.querySelector(".actual");
      if (anterior) anterior.classList.remove("actual");
      console.log(num_boton);
      e.target.classList.add("actual");
      // $.post("TASKS/coe-listColaboradores.php", { num_boton }, function (e) {
      //   const Usuario = JSON.parse(e);
      //   $("#list_tbodyOrador").html("");
      //   let template = "";
      //   Usuario.forEach((Usuario) => {
      //     template += `
      //     <tr idUsuario = "${Usuario.idUsuario}" correo = "${Usuario.correo}"">
      //     <td>${Usuario.nombre_completo}</td>
      //     <td><a href="#" class="action_href_user">${Usuario.idUsuario}</a></td>
      //     <td style="text-align: center;">${Usuario.area}</td>
      //     <td>${Usuario.idCuenta}</td>
      //     <td>${Usuario.subgerencia}</td>
      //     <td>${Usuario.correo}</td>
      //     <td>
      //       <button id="btn_delete_colaborador"><i class="bi bi-trash"></i></button>
      //     </td>
      //     <td>
      //         <button id="btn_edit_colaborador"><i class="bi bi-pencil-square"></i></button>
      //     </td>
      //     </tr>
      //             `;
      //   });
      //   $("#list_tbodyOrador").html(template);
      // });
      e.preventDefault();
    });
  });
  // INFO USUARIO
  $(document).on("click", ".action_href_user", (e) => {
    const element = $(this)[0].activeElement.parentElement.parentElement;
    const Usuario = $(element).attr("idUsuario");
    console.log(Usuario);
    $.post("TASKS/coe-list_infoUsuarios.php", { Usuario }, function (response) {
      const infoUsuario = JSON.parse(response);
      console.log(infoUsuario);
      let thead = `
          <tr>
            <th>Colaborador</th>
            <th>idRamo</th>
            <th>idCurso</th>
            <th>Aprobacion</th>
            <th>Estado</th>
          </tr>
            `;
      let template = "";
      infoUsuario.forEach((infoUsuario) => {
        template += `
          <tr idCurso = "${infoUsuario.idCurso}">
          <td>${infoUsuario.idUsuario}</td>
          <td>${infoUsuario.idRamo}</td>
          <td><a href="#" class="action_href_idCurso">${infoUsuario.idCurso}</a></td>
          <td>${infoUsuario.aprobacion}</td>    
          <td>${infoUsuario.estado}</td>    
          <td>
            <button id="btn_delete"><i class="bi bi-trash"></i></button>
          </td>
          <td>
                <button id="btn_edit"><i class="bi bi-pencil-square"></i></button>
            </td>
          </tr>
                  `;
      });
      $("#list_theadCuentas").html(thead);
      $("#list_tbodyCuentas").html(template);
    });
  });

  //PAGINADOR INFO USUARIO
  $(document).on("click", ".action_href_user", (e) => {
    $("#paginador").html("");
    $.ajax({
      url: "paginador/botones_colab.php",
      type: "GET",
      success: function (response) {
        $("#paginador").html(response);
      },
    });
    $(document).on("click", "#boton_paginador_colab", (e) => {
      const element = $(this)[0].activeElement;
      const num_boton = $(element).attr("num_pagina");
      const anterior = document.querySelector(".actual");
      if (anterior) anterior.classList.remove("actual");
      console.log(num_boton);
      e.target.classList.add("actual");
      // $.post("TASKS/coe-listColaboradores.php", { num_boton }, function (e) {
      //   const Usuario = JSON.parse(e);
      //   $("#list_tbodyOrador").html("");
      //   let template = "";
      //   Usuario.forEach((Usuario) => {
      //     template += `
      //     <tr idUsuario = "${Usuario.idUsuario}" correo = "${Usuario.correo}"">
      //     <td>${Usuario.nombre_completo}</td>
      //     <td><a href="#" class="action_href_user">${Usuario.idUsuario}</a></td>
      //     <td style="text-align: center;">${Usuario.area}</td>
      //     <td>${Usuario.idCuenta}</td>
      //     <td>${Usuario.subgerencia}</td>
      //     <td>${Usuario.correo}</td>
      //     <td>
      //       <button id="btn_delete_colaborador"><i class="bi bi-trash"></i></button>
      //     </td>
      //     <td>
      //         <button id="btn_edit_colaborador"><i class="bi bi-pencil-square"></i></button>
      //     </td>
      //     </tr>
      //             `;
      //   });
      //   $("#list_tbodyOrador").html(template);
      // });
      e.preventDefault();
    });
  });
  // INFO RELATOR
  $(document).on("click", ".action_href_relator", (e) => {
    const element = $(this)[0].activeElement.parentElement.parentElement;
    const relator = $(element).attr("relator");
    console.log(relator);
    $.post("TASKS/coe-list_infoRelator.php", { relator }, function (response) {
      const infoRelator = JSON.parse(response);
      console.log(infoRelator);
      let thead = `
    <tr>
      <th>Nombre orador</th>
      <th>Area</th>
      <th>Cuenta</th>
      <th>Cursos brindados</th>
    </tr>
          `;
      let template = "";
      infoRelator.forEach((infoRelator) => {
        template += `
        <tr idCuenta="${infoRelator.idCuenta}" nombreRamo="${infoRelator.nombreRamo}">
        <td>${infoRelator.relator}</td>
        <td>${infoRelator.area}</td>
        <td>
            <a href="#" class="action_href_cuenta">${infoRelator.idCuenta}</a>
        </td>
        <td>
            <a href="#" class="action_href_ramo">${infoRelator.nombreRamo}</a>
        </td>    
        <td>
          <button id="btn_delete"><i class="bi bi-trash"></i></button>
        </td>
        <td>
                <button id="btn_edit"><i class="bi bi-pencil-square"></i></button>
            </td>
        </tr>
                `;
      });
      $("#list_theadCuentas").html(thead);
      $("#list_tbodyCuentas").html(template);
    });
  });
  // PAGINADOR INFO RELATOR
  $(document).on("click", ".action_href_relator", (e) => {
    $("#paginador").html("");
    $.ajax({
      url: "paginador/botones_infoRelator.php",
      type: "GET",
      success: function (response) {
        $("#paginador").html(response);
      },
    });
    $(document).on("click", "#boton_paginador_infoRelator", (e) => {
      const element = $(this)[0].activeElement;
      const num_boton = $(element).attr("num_pagina");
      const anterior = document.querySelector(".actual");
      if (anterior) anterior.classList.remove("actual");
      console.log(num_boton);
      e.target.classList.add("actual");
      // $.post("TASKS/coe-listColaboradores.php", { num_boton }, function (e) {
      //   const Usuario = JSON.parse(e);
      //   $("#list_tbodyOrador").html("");
      //   let template = "";
      //   Usuario.forEach((Usuario) => {
      //     template += `
      //     <tr idUsuario = "${Usuario.idUsuario}" correo = "${Usuario.correo}"">
      //     <td>${Usuario.nombre_completo}</td>
      //     <td><a href="#" class="action_href_user">${Usuario.idUsuario}</a></td>
      //     <td style="text-align: center;">${Usuario.area}</td>
      //     <td>${Usuario.idCuenta}</td>
      //     <td>${Usuario.subgerencia}</td>
      //     <td>${Usuario.correo}</td>
      //     <td>
      //       <button id="btn_delete_colaborador"><i class="bi bi-trash"></i></button>
      //     </td>
      //     <td>
      //         <button id="btn_edit_colaborador"><i class="bi bi-pencil-square"></i></button>
      //     </td>
      //     </tr>
      //             `;
      //   });
      //   $("#list_tbodyOrador").html(template);
      // });
      e.preventDefault();
    });
  });
});
