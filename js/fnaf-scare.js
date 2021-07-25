authRoot.onAuthStateChanged(function (user) {
    if (user) {
        var userNaam = user.email.replace('@cryptatrix.com', '');
        var uid = user.uid;

        return dbRoot.ref(userNaam + "/" + uid + qno).once('value').then((snapshot) => {
            var vals = (snapshot.val());
            var ansCount = Object.keys(vals).length
            if (ansCount % 6 == 0) {
                fnaf_scare()
                const newPostKey = dbRoot.ref(userNaam + "/" + qno).push().key;
                var myNewValue = "";
                dbRoot.ref(userNaam + "/" + uid + qno).child(newPostKey).set({
                    myNewValue
                }, function (error) {
                    if (error) {
                        console.log(error);
                    }
                });
            };
        });
    }
})