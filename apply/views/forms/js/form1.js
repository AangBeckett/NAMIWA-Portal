var aff = document.getElementById("affiliateName");

function phoneFormat(input) {
    // Strip all characters from the input except digits
    input = input.replace(/\D/g, '');

    // Trim the remaining input to ten characters, to preserve phone number format
    input = input.substring(0, 10);

    // Based upon the length of the string, we add formatting as necessary
    var size = input.length;
    if (size == 0) {
        input = input;
    } else if (size < 4) {
        input = '(' + input;
    } else if (size < 7) {
        input = '(' + input.substring(0, 3) + ') ' + input.substring(3, 6);
    } else {
        input = '(' + input.substring(0, 3) + ') ' + input.substring(3, 6) + '-' + input.substring(6, 10);
    }
    return input;
}

function showfield(name) {
    if (name == '20') {
        document.getElementById('div1').innerHTML =
            '<div class="form-row">\n' +
            '<div class="form-group col-md-4">\n' +
            '<input type="text" class="form-control" name="otherName" id="otherName" required placeholder="NAMI Portland"/>\n' +
            '</div>\n' +
            '<div class="form-group col-md-4">\n' +
            '<input type="text" class="form-control" name="otherLeader" id="otherLeader" required placeholder="Your affiliate leader\'s name"/>\n' +
            '</div>\n' +
            '<div class="form-group col-md-4">\n' +
            '<input type="text" class="form-control" name="otherEmail" id="otherEmail" required placeholder="namipdx@gmail.com"/>\n' +
            '</div>\n' +
            '<div class="form-group col-md-4">\n' +
            '<input type="tel" class="form-control" name="otherPhone" id="otherPhone" required placeholder="503 987 1234"/>\n' +
            '</div>\n' +
            '</div>';
        document.getElementById('otherPhone').addEventListener('keyup', function (evt) {
            var otherPhone = document.getElementById('otherPhone');
            otherPhone.value = phoneFormat(otherPhone.value);
        });
    } else {
        document.getElementById('div1').innerHTML = '';
    }
}