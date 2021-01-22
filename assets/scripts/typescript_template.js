"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
console.log("Hello World!");
function Welcome(person) {
    return `Hey ${person.firstName} ${person.lastName}`;
}
const james = {
    firstName: "James",
    lastName: "Doe"
};
console.log(Welcome(james));
