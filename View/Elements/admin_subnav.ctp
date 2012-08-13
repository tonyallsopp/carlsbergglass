<nav id="admin-nav">
    <ul>
        <li class="admin-home">
            <a href="<?php echo $this->Html->url('/admin');?>"><span>Admin Tools</span></a>
        </li>
        <li class="my-account">
            <a href="<?php echo $this->Html->url('/account');?>"><span>My Account</span></a>
        </li>
        <li class="logout">
            <a href="<?php echo $this->Html->url('/users/logout');?>"><span>Logout</span></a>
        </li>
    </ul>
</nav>