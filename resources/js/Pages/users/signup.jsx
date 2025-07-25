import {useEffect} from "react";
import Layout from "@src/js/components/Layout.jsx";

export default function signup({
        email,
        emailError,
        password,
        password1Error,
        passwordConf,
        password2Error,
        dobError
}) {
    const appURL = window.REACT_APP.APP_URL;
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    useEffect(() => {
        document.title = "Sign Up";
    }, []);

    return (
        <Layout>
            <div className="container col-xl-10 col-xxl-8 px-4 py-5">
                <div className="row align-items-center g-lg-5 py-5">
                    <div className="col-md-10 mx-auto col-lg-5">
                        <form method="POST" action={appURL + "/signup"} className="p-4 p-md-5 border rounded-3 bg-body-tertiary">
                            <input type="hidden" name="_token" value={csrfToken} />
                            <div className="form-floating mb-3">
                                <input type="text" className={"form-control " + ((emailError != null && emailError !== '') ? "is-invalid" : "")} id="email" name="email"
                                       defaultValue={email} placeholder="name@example.com"/>
                                <label htmlFor="email">Email address</label>
                                <div className="invalid-feedback" id="emailError">{emailError}</div>
                            </div>
                            <div className="form-floating mb-3">
                                <input type="password" className={"form-control " + ((password1Error != null && password1Error !== '') ? "is-invalid" : "")}
                                       id="password" name="password" defaultValue={password} placeholder="Password"/>
                                <label htmlFor="password">Password</label>
                                <div className="invalid-feedback">{password1Error}</div>
                            </div>
                            <div className="form-floating mb-3">
                                <input type="password" className={"form-control " + ((password2Error != null && password2Error !== '') ? "is-invalid" : "")}
                                       id="password-conf" name="password-conf" defaultValue={passwordConf} placeholder="Confirm Password"/>
                                <label htmlFor="password-conf">Confirm Password</label>
                                <div className="invalid-feedback">{password2Error}</div>
                            </div>
                            <div className="form-floating mb-3">
                                <input type="date" className={"form-control " + ((dobError != null && dobError !== '') ? "is-invalid" : "")}
                                       id="dob" name="dob"/>
                                <label htmlFor="dob">Date Of Birth</label>
                                <div className="invalid-feedback">{dobError}</div>
                            </div>

                            <br/>
                            <button className="w-100 btn btn-lg btn-primary" type="submit">Sign up</button>
                            <hr className="my-4"/>
                            <small className="text-body-secondary">Already have an account?&nbsp;
                                <a href={appURL + "/login"}>Log in</a>
                            </small>
                        </form>
                    </div>
                </div>
            </div>
        </Layout>
);
}
