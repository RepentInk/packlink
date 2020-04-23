import moment from 'moment';

//convert words first letter to upper case
Vue.filter('upperCase', function(value) {
    if (!value) return '';
    value = value.toString();
    return value.charAt(0).toUpperCase() + value.slice(1);
});

//global for date human readable
Vue.filter('dateTime', function(created) {
    return moment(created).format('MMM Do, YYYY, hh:mm a');
});

Vue.filter('dateOnly', function(created) {
    return moment(created).format('MMM ddd Do, YYYY');
});

//substring in vue
Vue.filter('reduceText', function(text, length, suffix) {
    if (text.length > length) {
        return text.substring(0, length) + suffix;
    } else {
        return text;
    }
});

Vue.filter('toFixed', function(price, limit) {
    return price.toFixed(limit);
});