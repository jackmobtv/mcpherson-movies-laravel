function fullName(user) {
    let fullName = "Anonymous";

    if(user.firstName != null || user.lastName != null) fullName = user.firstName + " " + user.lastName;

    return fullName.trim();
}
export {fullName as fullName}

function displayDate(dateObj) {
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
export {displayDate as displayDate}
