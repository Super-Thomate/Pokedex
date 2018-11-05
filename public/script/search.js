/**************************/
/**    HANDLING NAME     **/
/**************************/
$("#name").on('input', function (evt) {
  let help                   = "Search for pokemon with any name." ;
  if ($(this).val())
    help                     = " Search for pokemon with '"+$(this).val()+"' in its name." ;
  $("#help_name").text(help) ;
}) ;
/**************************/
/**    HANDLING TYPES    **/
/**************************/
$(".types").on('click', function () {
  let that                   = $(this) ;
  let status                 = that.hasClass ("unselected") ;
  let id                     = this.id ;
  let allOperations          =
    $("#hi_operations").val ().split ('|').filter (function (operation) {
      return operation.length ;
    }) ;
  let allTypes               =
    $('#hi_types').val().split("|").filter (function (type) {
      return type.length ;
    }) ;
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
  write_help_types (allTypes, allOperations) ;
  $('#hi_types').val(allTypes.join("|")) ;
}) ;
$(".operator").on('click', function () {
  let that                   = $(this) ;
  let id                     = this.id ;
  let allOperations          =
    $("#hi_operations").val ().split ('|').filter (function (operation) {
      return operation.length ;
    }) ;
  let allTypes               =
    $('#hi_types').val().split("|").filter (function (type) {
      return type.length ;
    }) ;
  if (that.hasClass ("badge-disabled"))
    return ;
  switch (id) {
    case  'and':
     if (that.hasClass('badge-secondary')) {
       that.removeClass('badge-secondary').addClass('badge-success') ;
       $("#or").removeClass('badge-secondary').removeClass('pointer').addClass("badge-disabled") ;
       $("#mono").removeClass('badge-secondary').removeClass('pointer').addClass("badge-disabled") ;
       allOperations         = ["and"] ;
     } else {
       that.removeClass('badge-success').addClass('badge-secondary') ;
       $("#or").addClass('badge-secondary').addClass('pointer').removeClass("badge-disabled") ;
       $("#mono").addClass('badge-secondary').addClass('pointer').removeClass("badge-disabled") ;
       allOperations         = [] ;
     }
    break ;
    case 'mono':
    case   'or':
      if (that.hasClass('badge-secondary')) {
        that.removeClass('badge-secondary').addClass('badge-success') ;
        $("#and").removeClass('badge-secondary').removeClass('pointer').addClass("badge-disabled") ;
        allOperations     [allOperations.length] = id ;
      } else {
        that.removeClass('badge-success').addClass('badge-secondary') ;
        allOperations        = allOperations.filter (function (operation) {
          return (operation != id && operation.length) ;
        }) ;
        if (    $("#or").hasClass('badge-secondary')
             && $("#mono").hasClass('badge-secondary')
           )
          $("#and").addClass('badge-secondary').addClass('pointer').removeClass("badge-disabled") ;
      }
    break ;
  }
  write_help_types (allTypes, allOperations) ;
  $('#hi_operations').val(allOperations.join("|")) ;
}) ;
function write_help_types (allTypes, allOperations) {
  let help                   = "" ;
  if (! allTypes.length) {
    if (   (    allOperations.length == 1
             && allOperations [0] == "mono"
           )
        || allOperations.length == 2
       ) {
      help                  = "Search for pokemon with any mono-type." ;
    } else if (   allOperations.length == 1
               && allOperations [0] == "and"
              ) {
      help                  = "Search for pokemon with any double type." ;
    } else {
      help                  = "Search for pokemon with any type." ;
    }
  } else {
    if (   allOperations.length == 1
        && allOperations [0] != "mono"
       ) {
      let tmp                = "" ;
      switch (allOperations [0]) {
        case  "and":
          help               = "Search pokemon with types" ;
          for (let i = 0 ; i < allTypes.length-1 ; i++) {
            for (let j = i+1 ; j < allTypes.length ; j++) {
               if (   i == 0
                   && j == 1
                  ) {
                 tmp           += " "+allTypes [i]+" and "+allTypes [j] ;
               } else {
                 tmp           += ", "+allTypes [i]+" and "+allTypes [j] ;
               }
            }
          }
          help               = help+tmp+".";
        break ;
        case   "or":
          help               = "Search pokemon with types" ;
          for (let i = 0 ; i < allTypes.length ; i ++) {
            if (i == 0) {
              tmp           += " "+allTypes [i] ;
            } else {
              tmp           += " or "+allTypes [i] ;
            }
          }
          help               = help+tmp+".";
        break ;
      }
    } else if (allOperations.length) {
      let tmp                = "" ;
      help                   = "Search for pokemon with mono-type" ;
      for (let i = 0 ; i < allTypes.length ; i ++) {
        if (i == 0) {
          tmp               += " "+allTypes [i] ;
        } else {
          tmp               += " or "+allTypes [i] ;
        }
      }
      help                   = help+tmp+"." ;
    } else {
      let tmp                = "" ;
      help                   = "Search for pokemon with type" ;
      for (let i = 0 ; i < allTypes.length ; i ++) {
        if (i == 0) {
          tmp               += " "+allTypes [i] ;
        } else {
          tmp               += " or "+allTypes [i] ;
        }
      }
      help                   = help+tmp+"." ;
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
}) ;
