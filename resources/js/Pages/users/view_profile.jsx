import {useEffect} from "react";
import "@src/css/home.css"
import Layout from "@src/js/components/Layout.jsx";
import ProfileSidebar from "@src/js/components/Profile_Sidebar.jsx"
import ProfileHeader from "@src/js/components/Profile_Header.jsx"
import displayDate from "@src/js/script/date.js";

export default function view_profile({userJSON}) {
    const appURL = window.REACT_APP.APP_URL;
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const user = userJSON === undefined ? null : JSON.parse(userJSON);

    const fullName = () => {
        let fullName = "Anonymous";

        if(user.firstName != null || user.lastName != null) fullName = user.firstName + " " + user.lastName;

        return fullName.trim();
    }

    useEffect(() => {
        document.title = "Profile";

        const appDiv = document.getElementById('app');
        if (appDiv) {
            appDiv.removeAttribute('data-page');
        }
    }, []);

    return (
        <Layout>
            <main className="py-5">
                <ProfileHeader/>
                <section className="pt-3">
                    <div className="container">
                        <div className="row">
                            <ProfileSidebar user={user}/>

                            <div className="col-lg-9">
                                <div className="card bg-transparent border rounded-3">
                                    <div className="card-header border-bottom">
                                        <h3 className="card-header-title mb-0">Profile</h3>
                                    </div>

                                    <div className="card-body">
                                        {(user == null) ? (
                                            <h3>User Not Found</h3>
                                        ) : (
                                            <>
                                                <div className="d-flex justify-content-between align-items-center">
                                                    <div className="d-flex align-items-center">
                                                        <h3 className="mb-0">{fullName()}</h3>
                                                        <p className="mb-0 mx-3 text-secondary">
                                                            <i>{displayDate(user.dateofbirth)}</i>
                                                        </p>
                                                    </div>
                                                    <div className="d-flex align-items-center">
                                                        <h5 className="mb-0 mx-1">{user.pronouns}</h5>
                                                    </div>
                                                </div>

                                                <div className="mt-3">
                                                    <label htmlFor="description"
                                                           className="form-label">Description</label>
                                                    <textarea id="description" className="form-control" readOnly>{user.description}</textarea>
                                                </div>
                                            </>
                                        )}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </main>
        </Layout>
    );
}


