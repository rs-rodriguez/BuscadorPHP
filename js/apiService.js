$(function(){
    var Proceso = {
      formulario: $('#formulario'),
      $btnTodos: $('#mostrarTodos'),
      contDiv: $('#resultados'),
  
      Init: function(){
        var self = this
        self.cargarSelect()
        self.cargarTodos()
        self.formulario.submit(function(e){
          e.preventDefault()
          self.search()
        })
      },
      cargarSelect: function(){
        $('select').material_select()
      },
      search: function(e){
        var self = this
        var ciudad = $('form').find('select[id="selectCiudad"]').val()
        var tipo = $('form').find('select[id="selectTipo"]').val()
        var from = self.toNumero($('.irs-from').text())
        var to = self.toNumero($('.irs-to').text())
  
        var datos = {ciudad: ciudad, tipo: tipo, from: from, to: to}
        self.ajaxData(datos)
      },
      cargarTodos: function(){
        var self = this
        self.$btnTodos.on('click', (e)=>{
          var datos = {
              todos: ""
          }
          self.ajaxData(datos)
        })
      },
      ajaxData: function(datos){
        var self = this
        $.ajax({
          url: 'core/buscar.php',
          type: 'POST',
          data: datos
        }).done(function(data){
          var newData = JSON.parse(data)
          self.render(newData)
        })
      },
      toNumero: function(num){
        var numero = num
        var newNumero = Number(numero.replace('$', '').replace(',', '').replace(' ', ''))
        return newNumero
      },
      render: function(items){
        var self = this
        var item = items
        self.contDiv.html('')
  
        item.map((item)=>{
          var template = '<div class="itemMostrado card horizontal ">'+
                                '<div class="col s6">'+
                                  '<img src="img/home.jpg">'+
                                '</div>'+
                                '<div class="col s6">'+
                                '<div class="card-stacked">'+
                                  '<div class="card-content">'+
                                    '<div>'+
                                      '<b>Direccion: </b>:direccion:<p></p>'+
                                    '</div>'+
                                    '<div>'+
                                      '<b>Ciudad: </b>:ciudad:<p></p>'+
                                    '</div>'+
                                    '<div>'+
                                      '<b>Telefono: </b>:telefono:<p></p>'+
                                    '</div>'+
                                    '<div>'+
                                      '<b>Código postal: </b>:codigo_postal:<p></p>'+
                                    '</div>'+
                                    '<div>'+
                                      '<b>Precio: </b>:precio:<p></p>'+
                                    '</div>'+
                                    '<div>'+
                                      '<b>Tipo: </b>:tipo:<p></p>'+
                                    '</div>'+
                                  '</div>'+
                                  '<div class="card-action right-align">'+
                                    '<a href="#">Ver más</a>'+
                                  '</div>'+
                                '</div>'+
                              '</div>'+
                              '</div>';
  
          var newItem = template.replace(':direccion:', item.Direccion)
                                    .replace(':ciudad:', item.Ciudad)
                                    .replace(':telefono:', item.Telefono)
                                    .replace(':codigo_postal:', item.Codigo_Postal)
                                    .replace(':precio:', item.Precio)
                                    .replace(':tipo:', item.Tipo)
          self.contDiv.append(newItem)
        })
      }
    }
    Proceso.Init()
  })
  