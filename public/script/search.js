/**************************/
/**    HANDLING TYPES    **/
/**************************/
$(".types").on('click', function () {
  let that                   = $(this) ;
  let status                 = that.hasClass ("unselected") ;
  let id                     = this.id ;
  let allTypes               = $('#hi_types').val().split("|") ;
  if (status) {
    that.removeClass("unselected") ;
    allTypes         [allTypes.length] = id ;
    allTypes                 = allTypes.filter (function (type) {
      return type.length ;
    }) ;
  } else {
    that.addClass("unselected") ;
    allTypes                 = allTypes.filter (function (type) {
      return (type != id && type.length) ;
    }) ;
  }
  $('#hi_types').val(allTypes.join("|")) ;
}) ;
$(".operator").on('click', function () {
  let that                   = $(this) ;
  let id                     = this.id ;
  if (that.hasClass ("badge-disabled"))
    return ;
  switch (id) {
    case  'and':
     if (that.hasClass('badge-secondary')) {
       that.removeClass('badge-secondary').addClass('badge-success') ;
       $("#or").removeClass('badge-secondary').removeClass('pointer').addClass("badge-disabled") ;
       $("#mono").removeClass('badge-secondary').removeClass('pointer').addClass("badge-disabled") ;
     } else {
       that.removeClass('badge-success').addClass('badge-secondary') ;
       $("#or").addClass('badge-secondary').addClass('pointer').removeClass("badge-disabled") ;
       $("#mono").addClass('badge-secondary').addClass('pointer').removeClass("badge-disabled") ;
     }
    break ;
    case 'mono':
    case   'or':
      if (that.hasClass('badge-secondary')) {
        that.removeClass('badge-secondary').addClass('badge-success') ;
        $("#and").removeClass('badge-secondary').removeClass('pointer').addClass("badge-disabled") ;
      } else {
        that.removeClass('badge-success').addClass('badge-secondary') ;
        if (    $("#or").hasClass('badge-secondary') 
             && $("#mono").hasClass('badge-secondary')
           ) 
          $("#and").addClass('badge-secondary').addClass('pointer').removeClass("badge-disabled") ;
      }
    break ;
  }
}) ;

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
    allGens                  = allGens.filter (function (type) {
      return type.length ;
    }) ;
  } else {
    // Remove Generation to the search
    that.removeClass('badge-success').addClass('badge-secondary') ;
    allGens                  = allGens.filter (function (type) {
      return (type != generation && type.length) ;
    }) ;
  }
  // feedback
  let help                   = "" ;
  if (    allGens.length
       && allGens.length < 7
     ) {
    // there are gens but not all
    allGens.sort () ;
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
