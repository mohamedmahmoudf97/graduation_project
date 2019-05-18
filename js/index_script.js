
$(document).ready(function(){
    //wow fire function
    new WOW().init( );
    //owl carousel fire function
        $('.owl-carousel').owlCarousel({
            margin:10,
            nav:false,
            autoplay:true,
            autoplayTimeout:2000,
            autoplayHoverPause:false,
            responsive:{
                0:{
                    items:1
                },
                600:{
                    items:1
                },
                700:{
                    items:2
                },
                1000:{
                    items:3
                }
            }
        });
    //navbar scroll
    window.onscroll = function() {myFunction()};

    var header = document.getElementById("myHeader");
    var sticky = header.offsetTop;
    
    function myFunction() {
      if (window.pageYOffset > sticky) {
        header.classList.add("sticky");
      } else {
        header.classList.remove("sticky");
      }
    } 
//end navbar scroll



//strat login page
		
	//switch between login and signup
	$('.login-page h1 span').click(function(){
		$(this).addClass('selected').siblings().removeClass('selected');
		$('.login-page form').hide();
		$('.'+$(this).data('class')).fadeIn(300);
	});


	
	
	//hide placeholder on focus on inputs
		$('[placeholder]').focus(function(){
			$(this).attr('data-text',$(this).attr('placeholder'));
			$(this).attr('placeholder','');
		}).blur(function(){
			$(this).attr('placeholder',$(this).attr('data-text'));
		});
	
	
	//add astric to req field
	$('input').each(function(){
		if( $(this).attr('required') === 'required'){
			$(this).after('<span class="astrict">*</span>');
		}
	});
	
	
	///convert password to show
	var passfiled = $('.password');
	$('.show-pass').hover(function(){
		passfiled.attr('type','text');
	},function(){
		passfiled.attr('type','password');
	});
	

    $('.confirm').click(function(){
        return confirm('are you sure?');
    });
    
});
function getlegnth(tall,par_id,par_result_id,warning_id,btnid){
    var title = document.getElementById(par_id).value;
    var title_legnth = title.length;
    var result = document.getElementById(par_result_id).innerHTML= tall-title_legnth;	
    if(result < 0 ){
        document.getElementById(warning_id).innerHTML= "النص كبير";
        document.getElementById(par_result_id).style.display = "none";
        document.getElementById(btnid).disabled = true;
    }else{
        document.getElementById(warning_id).innerHTML= "";
        document.getElementById(par_result_id).style.display = "block";
        document.getElementById(btnid).disabled = false;
        }
    return;
}
