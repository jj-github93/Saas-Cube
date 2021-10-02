let range = document.getElementById("year")
let output = document.getElementById("output")
output.innerHTML = range.value;

range.oninput = function(){
    output.innerHTML = this.value;
}
