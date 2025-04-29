<!DOCTYPE html>
<html>
<head>
    <title>Quotes</title>
    <script src="{{ asset('vendor/quotes/quotes-component.umd.js') }}"></script>
    <link href="{{ asset('vendor/quotes/style.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <quotes-component></quotes-component>
    </div>

    <script>
        const { createApp } = Vue;
        const app = createApp({});
        app.component('quotes-component', QuotesComponent);
        app.mount('#app');
    </script>
</body>
</html> 