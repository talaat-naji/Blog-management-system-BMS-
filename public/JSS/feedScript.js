class services {
   
  
    async editText(postId, newText) {
        let jsonBody = JSON.stringify({ 'post_id': postId, 'new_text': newText });


        await fetch('/editText', {
            method: 'POST',
            body: jsonBody,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        });

    }

    

    async showPost(postId) {
        let jsonBody = JSON.stringify({ 'post_id': postId });


        await fetch('/post', {
            method: 'POST',
            body: jsonBody,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        });

    }

    async addFriends(uId) {
        let jsonBody = JSON.stringify({ 'toBeAdded': uId });
       
      //  prompt(uId);
      let response=  await fetch('/addFriend', {
            method: 'POST',
            body: jsonBody,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
      });
       // prompt(response);
        return response.json();
    }

    async getFollowStat(uId) { 
        let jsonBody = JSON.stringify({ 'toBeChecked': uId });
        let response=  await fetch('/followStat', {
            method: 'POST',
            body: jsonBody,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
      });
       // prompt(response);
        return response.json();
    }

}
service = new services();

async function hide(postId) {
    remdiv = document.getElementById("dform" + postId);
    cmnt = document.getElementById("c" + postId);
    remdiv.innerHTML = "";

    remdiv.append(cmnt);
    cmnt.setAttribute('onclick', 'comment(' + postId + ')');
}


async function edit(postId) {
    root = document.getElementById("editableText" + postId);
    let br = document.createElement('br');
    let ed = document.createElement('input');
    ed.className = "col-md-auto  ed";
    ed.placeholder = "Adjust your text!"

    let sub = document.createElement('button');
    sub.className = "col-md-auto justify-content-right";
    sub.innerText = " edit";
    root.append(br, ed, sub);

    sub.addEventListener('click', async (event) => {

        await service.editText(postId, ed.value);
        root.innerHTML = "";

        root.innerText = ed.value;

    })
}

function login() {
    alert("Login to benifit from our services :)");
}
function confirmm(postId) {
    let btn = postId + "del";
    let att = document.getElementById(btn);
    let r = confirm("are you sure you want to delete this post?");
    if (r) {
        att.submit();
    }
}



async function addFriend(uId) { 
    let approved = await service.addFriends(uId);
  
    let followbtn = document.getElementById('followbtn' + uId);
    
    if (approved == '') { followbtn.innerText = 'Follow'; }
    else {
        approved.forEach((approve) => {
       
            if (approve.approved == 1) {
                followbtn.innerText = 'Following';
            }
          
        });
  
    }
}
async function getFollowStatus(uId) {

    let approved = await service.getFollowStat(uId);
  
    let followbtn = document.getElementById('followbtn' + uId);
    
    if (approved == '') { followbtn.innerText = 'Follow'; }
    else {
        approved.forEach((approve) => {
       
            if (approve.approved == 1) {
                followbtn.innerText = 'Following';
            }
          
        });
  
    }
}