$(function(){
	$("#import_data").click(function(){		
		var parent = $(this).parent();
		var data={};
		var target_combo = "";
		var url = modul_name + "/view_upload";
		cari_ajax_combo("post", parent, data, target_combo, url, "proses_detail_map");
		
	})
	
	$(document).on("click", "#proses_import", function(){
		looding('light',$(this).closest(".row"));
		return true;
	})
});

function proses_detail_map(hasil){
	$("#modal_general").find(".modal-dialog").removeClass("fullscreen");
	$("#modal_general").find(".modal-title").html(hasil.ket);
	$("#modal_general").find(".modal-body").html(hasil.combo);
	$("#modal_general").find(".modal-footer").removeClass("hide");
	$("#modal_general").modal("show");
}