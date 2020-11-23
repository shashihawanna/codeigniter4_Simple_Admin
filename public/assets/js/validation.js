$("#login").validate({
  rules: {
    email: {
      required: true,
      email: true
    },
    password: {
      required: true,
    }
  },
 messages: {
  email: {
      required: "Enter email id",
      email: "Your email address must be in the format of name@domain.com"
    },
    password: {
      required: "Enter password",
    }
}
});

$("#profile-form").validate({
  rules: {
    firstname: {
      required: true
    },
    lastname: {
      required: true
    },
    email: {
      required: true,
      email: true
    },
    password: {
     
       minlength : 8,
    },
    password_confirm: {
    
      minlength : 8,
      equalTo : "#password"
    },

  },
 messages: {
  firstname: {
    required: "Enter First Name"
  },
  lastname: {
    required: "Enter Last Name"
  },
  email: {
      required: "Enter email id",
      email: "Your email address must be in the format of name@domain.com"
    },
    password: {
      minlength : "Enter 8 character password",
    },
    password_confirm: {
      minlength : "Enter 8 character password",
      equalTo : "Confirm password must be equal to password"
    },

}
});



$("#users-form").validate({
  rules: {
    firstname: {
      required: true
    },
    lastname: {
      required: true
    },
    email: {
      required: true,
      email: true
    },
    ut_id: {
      required: true,
    },
    password: {
      required: true,
       minlength : 8,
    },
    password_confirm: {
      required: true,
      minlength : 8,
      equalTo : "#password"
    },

  },
 messages: {
  firstname: {
    required: "Enter First Name"
  },
  lastname: {
    required: "Enter Last Name"
  },
  email: {
      required: "Enter email id",
      email: "Your email address must be in the format of name@domain.com"
    },
    ut_id: {
      required: "Select User Type",
    },
    password: {
      required: "Enter password",
      minlength : "Enter 8 character password",
    },
    password_confirm: {
      required: "Enter confirm password",
      minlength : "Enter 8 character password",
      equalTo : "Confirm password must be equal to password"
    },

}
});

$("#subject-form").validate({
  rules: {
    name: {
      required: true,
    },
    max_marks: {
      required: true,
      number:true
    }
  },
 messages: {
  name: {
      required: "Enter subject name",
    },
    max_marks: {
      required: "Enter max marks",
    }
}
});

$("#score-form").validate({
  rules: {
    student_id: {
      required: true,
    },
    subject_id: {
      required: true,
    },
    max_marks: {
      required: true,
      number:true
    },
    marks: {
      required: true,
      number:true
    }
  },
 messages: {
  name: {
      required: "Select subject name",
    },
    max_marks: {
      required: "Enter max marks",
    },
    marks: {
      required: "Enter marks",
    }
}
});

$("#student-form").validate({
  rules: {
    email: {
      required: true,
      email: true
    },
    name: {
      required: true,
    },
    dob:{
      required: true,
    },
    address: {
      required: true,
    }
  },
 messages: {
  email: {
      required: "Enter email d",
      email: "Your email address must be in the format of name@domain.com"
    },
    name: {
      required: "Enter name",
    },
    dob:{
      required: "Enter Date of Birth",
    },
    address: {
      required: "Enter address",
    }
}
});