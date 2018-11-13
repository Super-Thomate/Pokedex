/**************************/
/**    HANDLING NAME     **/
/**************************/
$("#name").on('input', function (evt) {
  let help                   = "Search for pokemon with any name." ;
  if ($(this).val())
    help                     = " Search for pokemon with '"+$(this).val()+"' in its name." ;
  $("#help_name").text(help) ;
  get_pokemons () ;
}) ;
/**************************/
/**    HANDLING TYPES    **/
/**************************/
$(".types").on('click', function () {
  let that                   = $(this) ;
  let status                 = that.hasClass ("unselected") ;
  let id                     = this.id ;
  let allTypes               =
    $('#hi_types').val().split("|").filter (function (type) {
      return type.length ;
    }) ;
  let alloperation          = $("#hi_operation").val ()  ;
  let or                     = $("#hi_or").val ()  ;
  if (status) {
    that.removeClass("unselected") ;
    allTypes         [allTypes.length] = id ;
  } else {
    that.addClass("unselected") ;
    allTypes                 = allTypes.filter (function (type) {
      return (type != id && type.length) ;
    }) ;
  }
  allTypes.sort () ;
  write_help_types (allTypes, alloperation, or) ;
  $('#hi_types').val(allTypes.join("|")) ;
  get_pokemons () ;
}) ;
/**************************/
/**  HANDLING OPERATORS  **/
/**************************/
$(".operator").on('click', function () {
  let that                   = $(this) ;
  let id                     = this.id ;
  let allTypes               =
    $('#hi_types').val().split("|").filter (function (type) {
      return type.length ;
    }) ;
  let alloperation          = $("#hi_operation").val ()  ;
  let or                     = $("#hi_or").val ()  ;
  switch (id) {
    case  'double':
     if (that.hasClass('badge-secondary')) {
        that.removeClass('badge-secondary').addClass('badge-success') ;
        $("#mono").removeClass('badge-secondary').addClass("badge-disabled") ;
        alloperation        = "double" ;
        $("#or").removeClass("badge-secondary unselected").addClass("badge-primary pointer") ;
     } else if (that.hasClass('badge-success')) {
        that.removeClass('badge-success').addClass('badge-secondary') ;
        $("#mono").removeClass("badge-disabled").addClass('badge-secondary') ;
        alloperation        = "" ;
        $("#or").removeClass("badge-primary badge-success pointer").addClass("badge-secondary unselected") ;
        $("#hi_or").val ('') ;
     } else {
        that.removeClass("badge-disabled").addClass('badge-success') ;
        $("#mono").removeClass('badge-success').addClass('badge-disabled') ;
        alloperation        = "double" ;
        $("#or").removeClass("badge-secondary unselected").addClass("badge-primary pointer") ;
     }
    break ;
    case 'mono':
      if (that.hasClass('badge-secondary')) {
        that.removeClass('badge-secondary').addClass('badge-success') ;
        $("#double").removeClass('badge-secondary').addClass("badge-disabled") ;
        alloperation         = "mono" ;
      } else if (that.hasClass('badge-success')) {
        that.removeClass('badge-success').addClass('badge-secondary') ;
        $("#double").removeClass("badge-disabled").addClass('badge-secondary') ;
        alloperation        = "" ;
     }  else {
        that.removeClass('badge-disabled').addClass('badge-success') ;
        $("#double").removeClass("badge-success").addClass('badge-disabled') ;
        alloperation         = "mono" ;
        $("#or").removeClass("badge-primary badge-success pointer").addClass("badge-secondary unselected") ;
        $("#hi_or").val ('') ;
      }
    break ;
  }
  write_help_types (allTypes, alloperation, or) ;
  $('#hi_operation').val(alloperation) ;
  get_pokemons () ;
}) ;
/**************************/
/**  HANDLING OR DOUBLE  **/
/**************************/
$("#or").on('click', function () {
  let that                   = $(this) ;
  if (that.hasClass("unselected")) {
    return ;
  }
  let allTypes               =
    $('#hi_types').val().split("|").filter (function (type) {
      return type.length ;
    }) ;
  let alloperation          = $("#hi_operation").val ()  ;
  let or                     = $("#hi_or").val () ;
  if (that.hasClass("badge-primary")) {
    that.removeClass("badge-primary").addClass("badge-success") ;
    or                       = "or" ;
  } else {
    that.removeClass("badge-success").addClass("badge-primary") ;
    or                       = "" ;
  }
  write_help_types (allTypes, alloperation, or) ;
  $("#hi_or").val (or) ;
  get_pokemons () ;
}) ;
/**************************/
/**  WRITE TYPES SEARCH  **/
/**************************/
function write_help_types (allTypes, alloperation, or) {
  let help                   = "" ;
  if (! allTypes.length) {
    if (alloperation == "mono") {
      help                  = "Search for pokemon with any mono-type." ;
    } else if (   alloperation.length
               && alloperation == "double"
              ) {
      help                  = "Search for pokemon with any double-types." ;
    } else {
      help                  = "Search for pokemon with any type." ;
    }
  } else {
    if (alloperation.length) {
      let tmp                = "" ;
      switch (alloperation) {
        case "double":
          help               = "Search for pokemon with" ;
          if (allTypes.length == 1) {
            help            += " any double-types including" ;
            tmp             += " "+allTypes [0] ;
          } else {
            if (or.length) {
              help          += " any double-types including" ;
              for (let i = 0 ; i < allTypes.length ; i++) {
                if (i == 0) {
                   tmp      += " "+allTypes [i] ;
                 } else if (i == allTypes.length-1) {
                   tmp       += " or "+allTypes [i] ;
                 } else {
                   tmp      += ", "+allTypes [i] ;
                 }
              }
            } else {
              help            += " double-types" ;
              for (let i = 0 ; i < allTypes.length-1 ; i++) {
                for (let j = i+1 ; j < allTypes.length ; j++) {
                   if (   i == 0
                       && j == 1
                      ) {
                     tmp    += " "+allTypes [i]+" and "+allTypes [j] ;
                   } else {
                     tmp    += ", "+allTypes [i]+" and "+allTypes [j] ;
                   }
                }
              }
            }
          }
          help              += tmp+".";
        break ;
        case   "mono":
          help               = "Search for pokemon with mono-type" ;
          for (let i = 0 ; i < allTypes.length ; i ++) {
            if (i == 0) {
              tmp           += " "+allTypes [i] ;
            } else if (i == allTypes.length-1) {
              tmp           += " or "+allTypes [i] ;
            } else {
              tmp           += ", "+allTypes [i] ;
            }
          }
          help              += tmp+"." ;
        break ;
      }
    } else {
      let tmp                = "" ;
      help                   = "Search for pokemon with type"+(allTypes.length>1?"s":"") ;
      for (let i = 0 ; i < allTypes.length ; i ++) {
        if (i == 0) {
          tmp               += " "+allTypes [i] ;
        } else if (i == allTypes.length-1) {
          tmp               += " or "+allTypes [i] ;
        } else {
          tmp               += ", "+allTypes [i] ;
        }
      }
      help                  += tmp+"." ;
    }
  }
  $("#help_types").text (help) ;
}
/**************************/
/** HANDLING GENERATIONS **/
/**************************/
$(".generation").on('click', function () {
  let that                   = $(this) ;
  let allGens                = $('#hi_generations').val().split("|") ;
  let generation             = this.id ;
  if (that.hasClass('badge-secondary')) {
    // Add Generation to the search
    that.removeClass('badge-secondary').addClass('badge-success') ;
    allGens [allGens.length] = generation ;
    allGens                  = allGens.filter (function (gen) {
      return gen.length ;
    }) ;
  } else {
    // Remove Generation to the search
    that.removeClass('badge-success').addClass('badge-secondary') ;
    allGens                  = allGens.filter (function (gen) {
      return (gen != generation && gen.length) ;
    }) ;
  }
  allGens.sort () ;
  // feedback
  let help                   = "" ;
  if (    allGens.length
       && allGens.length < 7
     ) {
    // there are gens but not all
    let tmp                  = "" ;
    for (let n = 0 ; n < allGens.length ; n++) {
      if (n == 0) {
        // first item
        tmp                 += allGens [n] ;
      } else if (n == allGens.length -1) {
        // last item
        tmp                 += " and "+allGens [n] ;
      } else {
        // in between
        tmp                 += ", "+allGens [n] ;
      }
    }
    help                    += "Search for generation "+tmp+"." ;
  } else {
    help                     = "Search for pokemon in any generation." ;
  }
  if (!help.length) {
    help                     = "Something went wrong." ;
  }
  $("#help_generations").text(help) ;
  $('#hi_generations').val(allGens.join("|")) ;
  get_pokemons () ;
}) ;
/**************************/
/** HANDLING GENERATIONS **/
/**************************/
function get_pokemons () {
  let name                   = $("#name").val() ;
  let types                  = $("#hi_types").val() ;
  let generations            = $("#hi_generations").val() ;
  let operation              = $("#hi_operation").val() ;
  let or                     = $("#hi_or").val() ;
  let params                 =
              {          "name": name
                ,       "types": types
                , "generations": generations
                ,   "operation": operation
                ,          "or": or
              } ;
  $.post("/search", params)
    .done(function (data) {
      if (data.error) {
        console.log (data) ;
        return ;
      }
      let table              = $("<table>")
                                 .attr ("id", "poke_table")
                                 .addClass("table table-striped table-bordered table-dark table-hover")
                                 .append (
                                   $("<thead>")
                                   .append (
                                     $("<tr>")
                                       .append($("<th>").text("Id"))
                                       .append($("<th>").text("Sprite"))
                                       .append($("<th>").text("Name"))
                                       .append($("<th>").text("Types"))
                                       .append($("<th>").text("Generation"))
                                   )
                                 )
                                 ;
      console.log (table) ;
      let tbody              = $("<tbody>") ;
      console.log (data) ;
    })
    .fail (function (e) {
      console.log (e.status, e.statusText) ;
    });
}