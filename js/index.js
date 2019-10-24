(function (){
    var checkboxes = document.querySelectorAll('.doctors input[type="checkbox"]');
    var allDocs = [];
    for (var i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i].checked) {
            allDocs.push(checkboxes[i].value);
        }
    }
    document.getElementById('alldocs').value = allDocs;
})();

function validateDocs() {
    var checkboxes = document.querySelectorAll('.doctors input[type="checkbox"]');
    var docs = 0;
    for (var i = 0; i < checkboxes.length; i++) {
        if(checkboxes[i].checked){
            docs += 1;
        }
    }
    if(docs == 0){
        alert('Ao menos um médico, por favor!');
        return false;
    }
};