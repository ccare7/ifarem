export default function (time) {
    let date = new Date(time*1000);
    let year = date.getFullYear();
    let month =date.getMonth()+1;
    let day =date.getDate();
    let hours = date.getHours();
    let mins = date.getMinutes();
    let sec = date.getSeconds();

    if(hours<10){
        hours = "0"+hours;
    }
    if(mins<10){
        mins = "0"+mins;
    }
    if(sec<10){
        sec = "0"+sec;
    }

    return `  ${year}/${month}/${day}/ ${hours}:${mins}:${sec}`;
}