$(document).ready(function () {

    $('#start_date').datepicker({
        dateFormat: 'yy-mm-dd',
        maxDate: '0'
    });
    $('#end_date').datepicker({
        dateFormat: 'yy-mm-dd',
        maxDate: '0'
    });

    // Client-side form validation
    $('#stock-form').on('submit', function (e) {
        var symbolInput = $('#company_symbol');
        var startDateInput = $('#start_date');
        var endDateInput = $('#end_date');
        var emailInput = $('#email');

        // Remove existing error messages
        $('.error').remove();

        // Validate Company Symbol
        if (symbolInput.val().trim() === '') {
            showError(symbolInput, 'Company Symbol is required');
            e.preventDefault();
        }

        // Validate Start Date
        if (startDateInput.val().trim() === '') {
            showError(startDateInput, 'Start Date is required');
            e.preventDefault();
        } else if (!isValidDate(startDateInput.val().trim())) {
            showError(startDateInput, 'Start Date must be a valid date');
            e.preventDefault();
        }

        // Validate End Date
        if (endDateInput.val().trim() === '') {
            showError(endDateInput, 'End Date is required');
            e.preventDefault();
        } else if (!isValidDate(endDateInput.val().trim())) {
            showError(endDateInput, 'End Date must be a valid date');
            e.preventDefault();
        }

        // Compare Start Date and End Date
        if (startDateInput.val().trim() !== '' && endDateInput.val().trim() !== '') {
            var startDate = new Date(startDateInput.val().trim());
            var endDate = new Date(endDateInput.val().trim());
            var currentDate = new Date();

            if (startDate > endDate) {
                showError(startDateInput, 'Start Date must be less than or equal to End Date');
                showError(endDateInput, 'End Date must be greater than or equal to Start Date');
                e.preventDefault();
            }

            if (startDate > currentDate) {
                showError(startDateInput, 'Start Date must be less than or equal to current date');
                e.preventDefault();
            }

            if (endDate > currentDate) {
                showError(endDateInput, 'End Date must be less than or equal to current date');
                e.preventDefault();
            }
        }

        // Validate Email
        var emailInputValue = emailInput.val().trim();

        if (emailInputValue === '') {
            showError(emailInput, 'Email is required');
            e.preventDefault();
        } else if (!validateEmail(emailInputValue)) {
            showError(emailInput, 'The email must be a valid email address.');
            e.preventDefault();
        }

        return true;
    });

    var symbolInput = $('#company_symbol')
    symbolInput.on('change', function(evt) {
        evt.preventDefault();
         // Remove existing error messages
         $('.error').remove();
         // validate
        if(!validateCompanySymbol(symbolInput.val())) {
            showError(symbolInput, 'Invalid Company Symbol');
        }
    })

    // Helper function to display error message
    function showError(input, message) {
        var errorElement = $('<div class="error">' + message + '</div>');
        input.after(errorElement);
    }

    // Helper function to validate email format
    function validateEmail(email) {
        var regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return regex.test(email);
    }

    // Helper function to validate date format
    function isValidDate(dateString) {
        var dateRegex = /^\d{4}-\d{2}-\d{2}$/;
        return dateRegex.test(dateString) && !isNaN(Date.parse(dateString));
    }

      // Function to validate Company Symbol
      function validateCompanySymbol(symbol) {
        var apiUrl = 'https://pkgstore.datahub.io/core/nasdaq-listings/nasdaq-listed_json/data/a5bc7580d6176d60ac0b2142ca8d7df6/nasdaq-listed_json.json';
        var isValid = false;
        $.ajax({
            url: apiUrl,
            dataType: 'json',
            success: function (data) {
                var validSymbols = data.map(function (company) {
                    return company.Symbol;
                });
                isValid = validSymbols.includes(symbol);

            },
            error: function () {
                console.log('something went wrong.');
            }
        });
        return isValid;
    }
});
