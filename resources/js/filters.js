Vue.filter('capitalize', function (text) {
    return text.charAt(0).toUpperCase() + text.slice(1);
})

Vue.filter('formatDate', function (date) {
    const dateObj = new Date(date);
    const options = { month: 'long' };
    const monthName = dateObj.toLocaleString('en-US', options);

    return `${monthName} ${dateObj.getDate()}, ${dateObj.getFullYear()}`
})
