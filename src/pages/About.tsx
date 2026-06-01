import { Target, Eye, Heart, Briefcase } from 'lucide-react';

export default function About() {
  const values = [
    {
      icon: Target,
      title: 'Our Mission',
      description: 'To empower businesses with innovative solutions that drive growth and success in the digital age.',
    },
    {
      icon: Eye,
      title: 'Our Vision',
      description: 'To be the leading provider of business solutions, recognized for excellence and innovation.',
    },
    {
      icon: Heart,
      title: 'Our Values',
      description: 'Integrity, excellence, innovation, and customer satisfaction are at the core of everything we do.',
    },
  ];

  const team = [
    {
      name: 'John Smith',
      role: 'CEO & Founder',
      bio: '15+ years of experience in business consulting and strategic planning.',
    },
    {
      name: 'Sarah Johnson',
      role: 'Chief Operations Officer',
      bio: 'Expert in operational excellence and process optimization.',
    },
    {
      name: 'Michael Chen',
      role: 'Head of Technology',
      bio: 'Leading our technical innovation and digital transformation initiatives.',
    },
    {
      name: 'Emily Davis',
      role: 'Customer Success Manager',
      bio: 'Dedicated to ensuring exceptional client experiences and satisfaction.',
    },
  ];

  return (
    <div>
      {/* Hero Section */}
      <section className="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-20">
        <div className="container mx-auto px-4">
          <h1 className="text-5xl font-bold mb-6">About Us</h1>
          <p className="text-xl max-w-3xl">
            We are a team of passionate professionals dedicated to helping businesses
            achieve their full potential through innovative solutions and expert guidance.
          </p>
        </div>
      </section>

      {/* Company Story */}
      <section className="py-20">
        <div className="container mx-auto px-4">
          <div className="max-w-4xl mx-auto">
            <h2 className="text-4xl font-bold mb-8 text-center">Our Story</h2>
            <div className="space-y-6 text-lg text-gray-700">
              <p>
                Founded in 2020, Business Solutions was born from a simple idea: businesses
                deserve better tools and guidance to navigate the complexities of the modern
                marketplace. Our founders, experienced professionals from various industries,
                came together with a shared vision of creating a company that truly puts
                client success first.
              </p>
              <p>
                Over the years, we've grown from a small startup to a trusted partner for
                hundreds of businesses across different sectors. Our success is built on a
                foundation of expertise, innovation, and unwavering commitment to delivering
                exceptional results.
              </p>
              <p>
                Today, we continue to evolve and adapt, staying ahead of industry trends
                and technological advancements to provide our clients with cutting-edge
                solutions that drive real, measurable results.
              </p>
            </div>
          </div>
        </div>
      </section>

      {/* Values Section */}
      <section className="bg-gray-100 py-20">
        <div className="container mx-auto px-4">
          <h2 className="text-4xl font-bold mb-12 text-center">What Drives Us</h2>
          <div className="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
            {values.map((value, index) => {
              const Icon = value.icon;
              return (
                <div
                  key={index}
                  className="bg-white p-8 rounded-lg shadow-lg text-center"
                >
                  <div className="bg-blue-100 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <Icon className="text-blue-600" size={36} />
                  </div>
                  <h3 className="text-2xl font-semibold mb-4">{value.title}</h3>
                  <p className="text-gray-600">{value.description}</p>
                </div>
              );
            })}
          </div>
        </div>
      </section>

      {/* Team Section */}
      <section className="py-20">
        <div className="container mx-auto px-4">
          <h2 className="text-4xl font-bold mb-12 text-center">Meet Our Team</h2>
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            {team.map((member, index) => (
              <div
                key={index}
                className="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow"
              >
                <div className="bg-gradient-to-br from-blue-500 to-blue-700 h-48 flex items-center justify-center">
                  <Briefcase className="text-white" size={64} />
                </div>
                <div className="p-6">
                  <h3 className="text-xl font-semibold mb-2">{member.name}</h3>
                  <p className="text-blue-600 font-medium mb-3">{member.role}</p>
                  <p className="text-gray-600 text-sm">{member.bio}</p>
                </div>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* CTA Section */}
      <section className="bg-blue-600 text-white py-16">
        <div className="container mx-auto px-4 text-center">
          <h2 className="text-3xl font-bold mb-4">Want to Work With Us?</h2>
          <p className="text-xl mb-8">
            Let's collaborate and create something amazing together.
          </p>
          <button className="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold text-lg hover:bg-gray-100 transition-colors">
            Get in Touch
          </button>
        </div>
      </section>
    </div>
  );
}
