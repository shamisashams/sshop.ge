$((function(){$("#checkoutsteps").steps({headerTag:"h4",bodyTag:"section",transitionEffect:"fade",enableAllSteps:!0,transitionEffectSpeed:500,onStepChanging:function(e,s,t){return 1===t?$(".steps ul").addClass("step-2"):$(".steps ul").removeClass("step-2"),2===t?$(".steps ul").addClass("step-3"):$(".steps ul").removeClass("step-3"),3===t?($(".steps ul").addClass("step-4"),$(".actions ul").addClass("step-last")):($(".steps ul").removeClass("step-4"),$(".actions ul").removeClass("step-last")),!0},labels:{finish:"Order again",next:"Next",previous:"Previous"}}),$(".wizard > .steps li a").click((function(){$(this).parent().addClass("checked"),$(this).parent().prevAll().addClass("checked"),$(this).parent().nextAll().removeClass("checked")})),$(".forward").click((function(){$("#wizard").steps("next")})),$(".backward").click((function(){$("#wizard").steps("previous")})),$(".checkbox-circle label").click((function(){$(".checkbox-circle label").removeClass("active"),$(this).addClass("active")})),$("#checkoutsteps .steps").prepend("<div class='checkoutline'></div>")}));