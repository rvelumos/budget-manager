<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>
<body>
    <div id="app">
        <chart-component
            type="expenses"
            title="Expenses"
            chart-id="expensesChart">
        </chart-component>

        <chart-component
            type="incomes"
            title="Incomes"
            chart-id="incomesChart">
        </chart-component>
    </div>

    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
