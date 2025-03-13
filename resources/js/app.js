import './bootstrap';
import Search from "./live-search";
import Chat from "./chat";
import Profile from "./profile";


if (document.querySelector(".profile-nav")) {
    new Profile();
}


if(document.querySelector(".header-search-icon")) {
    new Search();
}


document.addEventListener("DOMContentLoaded", () => {
    if (document.querySelector("#chat-wrapper")) {
        new Chat();
    }
});