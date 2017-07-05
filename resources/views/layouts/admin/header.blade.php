<nav v-if="auth.loggedIn()" class="admin-navigation">
    <ul>
        <li><a href="#">Projects</a>
            <ul class="dropdown">
                <router-link :to="{name: 'admin-projects'}" tag="li" exact><a>List</a></router-link>
                <router-link :to="{name: 'admin-projects-sticky'}" tag="li" exact><a>Sticky List</a></router-link>
                <router-link :to="{name: 'admin-project-create'}" tag="li" exact><a>Create</a></router-link>
            </ul>
        </li>
        <li><a href="#">Links</a>
            <ul class="dropdown">
                <router-link :to="{name: 'admin-links'}" tag="li" exact><a>List</a></router-link>
                <router-link :to="{name: 'admin-link-create'}" tag="li" exact><a>Create</a></router-link>
            </ul>
        </li>
    </ul>
</nav>
