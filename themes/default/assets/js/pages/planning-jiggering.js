$(function(){
	$(document).on("change","input[name='mould_akt[]'], input[name='jml_cycle[]'], input[name='shift[]'], input[name='plan_down[]']",function(){	
		var nil1=$(this).closest("tr").find("input[name='mould_akt[]']").val();
		var nil2=$(this).closest("tr").find("input[name='jml_cycle[]']").val();
		var nil3=$(this).closest("tr").find("input[name='shift[]']").val();
		var nil4=$(this).closest("tr").find("input[name='plan_down[]']").val();
		var nil5 = (nil1*nil2*nil3)*(1-nil4/100);
		$(this).closest("tr").find("input[name='total_target[]']").val(Math.round(nil5));	
	})
	
	$(document).on("change","input[name='total_target[]'], input[name='yield[]']",function(){	
		var nil1=$(this).closest("tr").find("input[name='total_target[]']").val();
		var nil2=$(this).closest("tr").find("input[name='yield[]']").val();
		var nil3 = nil1*(nil2/100);
		$(this).closest("tr").find("input[name='lulus_target[]']").val(Math.round(nil3));	
	})
	
	$("#l_pabrik_no").change(function(){
		var parent = $("#l_detail_detail");
		var id = $(this).val();
		var data={'id':id};
		var target_combo = $("#l_detail_detail");
		var url = modul_name + "/detail_plan";
		cari_ajax_combo("post", parent, data, target_combo, url);
	})
});