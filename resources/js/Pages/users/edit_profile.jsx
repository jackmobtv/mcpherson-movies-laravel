import {useEffect} from "react";
import "@src/css/home.css"
import Layout from "@src/js/components/Layout.jsx";
import Profile_Sidebar from "@src/js/components/Profile_Sidebar.jsx";
import Profile_Header from "@src/js/components/Profile_Header.jsx";

export default function edit_profile({userJSON}) {
    const appURL = window.REACT_APP.APP_URL;
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const user = userJSON === undefined ? null : JSON.parse(userJSON);

    useEffect(() => {
        document.title = "Edit Profile";

        const appDiv = document.getElementById('app');
        if (appDiv) {
            appDiv.removeAttribute('data-page');
        }
    }, []);

    return (
        <Layout>
            <>
                <main>
                    <Profile_Header/>

                    <section className="pt-0">
                        <div className="container">
                            <div className="row">
                                <Profile_Sidebar/>

                                <div className="col-lg-9">
                                    <div className="card bg-transparent border rounded-3">
                                        <div className="card-header border-bottom">
                                            <h3 className="card-header-title mb-0">Edit Profile</h3>
                                        </div>
                                        <div className="card-body">
                                            <form className="row g-4" action={appURL + "/edit-profile"} method="POST">
                                                <input type="hidden" name="_token" value={csrfToken} />
                                                <div className="col-md-6">
                                                    <label className="form-label" htmlFor="firstName">First Name</label>
                                                    <input
                                                        className="form-control"
                                                        type="text" id="firstName" name="firstName"
                                                        defaultValue={user.firstName}/>
                                                </div>

                                                <div className="col-md-6">
                                                    <label className="form-label" htmlFor="lastName">Last Name</label>
                                                    <input type="text"
                                                           className="form-control"
                                                           id="lastName" name="lastName" defaultValue={user.lastName}/>
                                                </div>

                                                <div className="col-md-6">
                                                    <label className="form-label" htmlFor="email">Email</label>
                                                    <input
                                                        className="form-control"
                                                        type="text" id="email" name="email" defaultValue={user.email}/>
                                                </div>

                                                <div className="col-md-6">
                                                    <label className="form-label" htmlFor="phone">Phone number</label>
                                                    <input type="text"
                                                           className="form-control"
                                                           id="phone" name="phone" defaultValue={user.phone}/>
                                                </div>

                                                <div className="col-md-6">
                                                    <label className="form-label" htmlFor="language">Language</label>
                                                    <select
                                                        className="form-select js-choice z-index-9"
                                                        aria-label=".form-select-sm" id="language" name="language" defaultValue={user.language}>
                                                        <option value="en-US">English</option>
                                                        <option value="es-MX">Spanish</option>
                                                        <option value="fr-FR">French</option>
                                                    </select>
                                                </div>

                                                <div className="col-md-6">
                                                    <label className="form-label" htmlFor="pronouns">Pronouns</label>
                                                    <input type="text"
                                                           className="form-control"
                                                           id="pronouns" name="pronouns" defaultValue={user.pronouns}/>
                                                </div>

                                                <div className="col-md-12">
                                                    <label className="form-label"
                                                           htmlFor="description">Description</label>
                                                    <textarea
                                                        className="form-control"
                                                        id="description" name="description"
                                                        rows="3">
                                                        {user.description}
                                                    </textarea>
                                                </div>

                                                <div className="d-sm-flex justify-content-end">
                                                    <button type="submit" className="btn btn-secondary mb-0">
                                                        Save Changes
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </main>
            </>
        </Layout>
    );
}


