function givestars(n, sectionId) {
    // Get stars and output specific to the section
    let section = document.getElementById(sectionId);
    let stars = section.getElementsByClassName("star");
    let output = document.getElementById("output-" + sectionId.split("-")[0]);

    // Update the color based on the rating
    remove(stars);  // Pass the specific stars to remove their classes
    for (let i = 0; i < n; i++) {
        let cls = ["one", "two", "three", "four", "five"][n - 1];
        stars[i].className = "star " + cls;
    }
    output.innerText = "Rating is: " + n + "/5";

    return n;
}

// Remove function to take stars array as an argument
function remove(stars) {
    for (let i = 0; i < stars.length; i++) {
        stars[i].className = "star";
    }
}
