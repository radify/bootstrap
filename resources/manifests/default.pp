define apache::loadmodule () {
	exec { "/usr/bin/a2enmod $name" :
		unless => "/bin/ls /etc/apache2/mods-enabled/${name}.load",
		notify => Service['apache2']
	}
}


group { "puppet":
	ensure => "present"
}

exec { "apt-get update":
	command => "/usr/bin/apt-get update"
}

Package {
	require => Exec["apt-get update"]
}
File {
	require => Exec["apt-get update"]
}

package { "make":
	ensure => present
}
package { "vim":
	ensure => present
}
package { "apache2":
	ensure => present
}
package { "php5-dev":
	ensure => present,
	require => Package['apache2']
}
package { "libapache2-mod-php5":
	ensure => present,
	require => [Package['apache2'], Package['php5-dev']]
}
package { "php-pear":
	ensure => present,
}
package { "php5-xdebug":
	ensure => present,
}
package { "php5-mcrypt":
	ensure => present,
}
package { "mongodb":
	ensure => present,
}

exec {"/usr/bin/pecl install mongo":
	require => [Package['php5-dev'], Package['libapache2-mod-php5'], Package['make']]
}
exec {"/usr/bin/sudo ln -sf /etc/php5/apache2/php.ini /etc/php5/cli/php.ini":
	require => Package['php5-dev']
}
exec {"/bin/rm /etc/php5/cli/conf.d/mcrypt.ini":
	require => Package['php5-mcrypt']
}
apache::loadmodule{"rewrite": }

service { "apache2":
	ensure => running,
	enable => true,
	require => [Package['apache2'], File["/etc/php5/apache2/php.ini"]],
	subscribe => [
		File["/etc/apache2/mods-enabled/rewrite.load"],
		File["/etc/apache2/sites-available/default"]
	]
}

file { "/etc/apache2/mods-enabled/rewrite.load":
	ensure => link,
	target => "/etc/apache2/mods-available/rewrite.load",
	require => Package['apache2']
}
file { "/etc/apache2/sites-available/default":
	ensure => present,
	source => "/vagrant/_build/manifests/default.conf"
}

file {["/etc/php5", "/etc/php5/apache2"] :
	ensure => "directory"
}

file { "/etc/php5/apache2/php.ini":
	ensure => present,
	require => [Package['apache2'], Package['php5-dev'], Package['libapache2-mod-php5']],
	source => "/vagrant/_build/manifests/php.ini"
}
