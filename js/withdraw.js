var buttons = document.querySelectorAll("#alpha button");

for(var i = 0; i < buttons.length; i++){
  var btn = buttons[i];
  btn.addEventListener("click", function() {
    document.getElementById("textbox").value += this.innerHTML;
  });
}