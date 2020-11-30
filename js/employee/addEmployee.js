function preview_image(event,pic) 
{
 var reader = new FileReader();
 reader.onload = function()
 {
  var output = document.getElementById(`output_image${pic}`);
  output.src = reader.result;
 }
 reader.readAsDataURL(event.target.files[0]);
}