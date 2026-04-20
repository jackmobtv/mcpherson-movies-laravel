export default function displayDate(dateObj) {
    console.log(dateObj.date)
    const date = new Date(dateObj.date + 'Z');

    const options = {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit',
        timeZoneName: 'short'
    };

    return date.toLocaleString(undefined, options);
}
